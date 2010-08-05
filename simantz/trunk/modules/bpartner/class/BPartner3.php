<?php


class BPartner
{
  public	$bpartner_id;
  public	$bpartnergroup_id;
  public	$bpartner_no;
  public	$bpartner_name;
  public	$isactive;
  public	$defaultlevel;
  public	$created;
  public	$createdby;
  public	$updated;
  public	$updatedby;
  public	$currency_id;
  public	$terms_id;
  public	$salescreditlimit;
  public	$organization_id;
  public	$bpartner_url;
  public	$debtoraccounts_id;
  public	$description;
  public	$tax_id;
  public	$currentbalance;
  public	$creditoraccounts_id;
  public	$isdebtor;
  public	$iscreditor;
  public	$istransporter;
  public	$purchasecreditlimit;
  public	$enforcesalescreditlimit;
  public	$enforcepurchasecreditlimit;
  public	$currentsalescreditstatus;
  public	$currentpurchasecreditstatus;
  public	$bankaccountname;
  public	$bankname;
  public	$bankaccountno;
  public	$isdealer;
  public	$isprospect;
  public	$employeecount;
  public	$alternatename;
  public	$companyno;
  public	$industry_id;
  public $updatesql;
  public $orgctrl;
  public $industryctrl;
  public $accounclassctrl;

  public $bpartnergroup_name;
  public $currency_code;
  public $industry_name;


  private $xoopsDB;

  private $tablebpartner;
  private $tablebpartnergroup;
  private $tableaccounts;
  private $tableindustry;
  private $tablecurrency;
  private $tablecountry;
  private $tableterms;
  private $log;


//constructor
   public function BPartner(){
	global $xoopsDB,$log,$tablebpartner,$tablebpartnergroup,$tableorganization,$tableaccounts,
            $tablecountry,$tablecurrency,$tableterms,$tableindustry;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablebpartner=$tablebpartner;
	$this->tablebpartnergroup=$tablebpartnergroup;
    $this->tableindustry=$tableindustry;
	$this->tableaccounts=$tableaccounts;
	$this->tablecountry=$tablecountry;
	$this->tableterms=$tableterms;
	$this->tablecurrency=$tablecurrency;
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
  public function getInputForm( $type,  $bpartner_id,$token  ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";
	$hide="style='display:none'";
	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Business Partner";
		$action="create";
	 	
		if($bpartner_id==0){
			$this->bpartner_name="";
			$this->isactive=1;
			$this->defaultlevel=10;
            $this->employeecount=0;
            $this->currentpurchasecreditstatus=0;
            $this->currentbalance=0;
            $this->currentsalescreditstatus=0;
            $this->salescreditlimit=0;
            $this->purchasecreditlimit=0;

	
		}
		$savectrl="<input style='height: 20px;' name='submit' value='Save' type='submit'>";
		$checked="CHECKED";
		$deletectrl="";
		$addnewctrl="";
		$selectStock="";
		$selectClass="";
		$selectCharge="";

		$this->bpartner_no = getNewCode($this->xoopsDB,"bpartner_no",$this->tablebpartner);

	
	}
	else
	{
		
		$action="update";
		$savectrl="<input name='bpartner_id' value='$this->bpartner_id' type='hidden'>
			<input style='height: 40px;' name='submit' value='Save' 
            type='submit' onclick='action.value=\"update\"'></td><td>
            <input style='height: 40px;' name='submit' value='Cancel'
            type='submit' onclick='action.value=\"view\"'>";

		

		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablebpartner' type='hidden'>".
		"<input name='id' value='$this->bpartner_id' type='hidden'>".
		"<input name='idname' value='bpartner_id' type='hidden'>".
		"<input name='title' value='BPartner' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";
		

		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

		if ($this->isdebtor==1)
			$isdebtorchecked="CHECKED";
		else
			$isdebtorchecked="";

		if ($this->iscreditor==1)
			$iscreditorchecked="CHECKED";
		else
			$iscreditorchecked="";

		if ($this->istransporter==1)
			$istransporterchecked="CHECKED";
		else
			$istransporterchecked="";

		if ($this->isdealer==1)
			$isdealerchecked="CHECKED";
		else
			$isdealerchecked="";

		if ($this->isprospect==1)
			$isprospectchecked="CHECKED";
		else
			$isprospectchecked="";

		if ($this->enforcesalescreditlimit==1)
			$enforcesalescreditlimitchecked="CHECKED";
		else
			$enforcesalescreditlimitchecked="";

		if ($this->enforcepurchasecreditlimit==1)
			$enforcepurchasecreditlimitchecked="CHECKED";
		else
			$enforcepurchasecreditlimitchecked="";

		$header="Edit Business Partner";
		
		if($this->allowDelete($this->bpartner_id))
		$deletectrl="<FORM action='bpartner.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this bpartner?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->bpartner_id' name='bpartner_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='bpartner.php' method='POST'><input name='submit' value='New' type='submit'></form>";
	}

    echo <<< EOF
<script type='text/javascript'>
    function showAccountParameter(){
        var trAccountParameter=document.getElementById("trAccountParameter");
        var btnShowAccountParameter=document.getElementById("btnShowAccountParameter");
        if(trAccountParameter.style.display=="none"){
            trAccountParameter.style.display="";
            btnShowAccountParameter.value="Hide Account Info";
        }
        else{
            trAccountParameter.style.display="none";
            btnShowAccountParameter.value="Display Account Info";
        }
    }
</script>
<form onsubmit="return validateBPartner()" method="post"
 action="bpartner.php" name="frmBPartner"><table style="width:140px;"><tbody><td><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
   	<td class="head">Business Partner Group $mandatorysign</td>
        <td class="even" >$this->bpartnergroupctrl</td>
      </tr>
      <tr>
       <td class="head">Business Partner No $mandatorysign</td>
        <td class="even" ><input maxlength="10" size="10" name="bpartner_no" value="$this->bpartner_no">
	&nbsp;Active <input type="checkbox" $checked name="isactive"> Default Level $mandatorysign <input maxlength="3" size="3" name='defaultlevel' value='$this->defaultlevel'>
        <td class="head">Business Partner Name $mandatorysign</td>
        <td class="even" ><input maxlength="50" size="35" name="bpartner_name" value="$this->bpartner_name">
		</td>
      </tr>

      <tr>
    	<td class="head">Company No</td>
	    <td class="even" ><input name='companyno' value="$this->companyno"></td>
        <td class="head">Alternate Name</td>
	    <td class="even" ><input name='alternatename' value='$this->alternatename'></td>
      </tr>
      <tr>
    	<td class="head">Industry</td>
	    <td class="even" >$this->industryctrl</td>
        <td class="head">Employee Count</td>
	    <td class="even" ><input name='employeecount' value='$this->employeecount'></td>
      </tr>
     <tr $hide>
    	<td class="head">Is Debtor (Customer)</td>
	    <td class="even" ><input type='checkbox' name='isdebtor' $isdebtorchecked></td>
        <td class="head">Is Creditor (Supplier)</td>
	    <td class="even" ><input type='checkbox' name='iscreditor' $iscreditorchecked></td>
      </tr>
     <tr $hide>
    	<td class="head">Is Transporter</td>
	    <td class="even" ><input type='checkbox' name='istransporter' $istransporterchecked></td>
        <td class="head">Is Dealer</td>
	    <td class="even" ><input type='checkbox' name='isdealer' $isdealerchecked></td>
      </tr>
     <tr $hide>
    	<td class="head">Is Prospect</td>
	    <td class="even" ><input type='checkbox' name='isprospect' $isprospectchecked></td>
        <td class="head">Terms</td>
	    <td class="even" >$this->termsctrl</td>
      </tr>

       <tr>
        <td class="head">Tooltips</td>
	    <td class="even"><input name='tooltips' value='$this->tooltips' size='45'></td>
        <td class="head">Website</td>
	    <td class="even"><input name='bpartner_url' value='$this->bpartner_url' size='45'></td>
      </tr>
      <tr>
        <td class="head">Description</td>
	    <td class="even" colspan='3'>
                <textarea cols='65' rows='6' name='description'>$this->description</textarea>
                
                
        </td>
      </tr>
      <tr $hide>
        <td class="head">Currency</td>
        <td class="even" >$this->currencyctrl</td>
    	<td class="head"></td>
    	<td class="even" >
                <input type='button' value='Display Account Info'
                        id='btnShowAccountParameter' onclick='showAccountParameter()'>
        </td>
      </tr>
      <tr id='trAccountParameter' style='display:none'><td colspan='4' class='even'>
        Accounting Parameter:<br>
        <table><tbody>
           <tr>
            <td class="foot">Debtor Account</td>
	        <td class="odd" id="iddebtoraccountsctrl">$this->debtoraccountsctrl<input type='hidden' name='previousaccounts_id' value="$this->debtoraccounts_id"></td>
            <td class="foot">Creditor Account</td>
	        <td class="odd" id="idcreditoraccountsctrl">$this->creditoraccountsctrl<input type='hidden' name='previousaccounts_id' value="$this->creditoraccounts_id"></td>
           </tr>
           <tr>
            <td class="foot">Sales Credit Limit</td>
	        <td class="odd"><input name='salescreditlimit' value="$this->salescreditlimit"></td>
            <td class="foot">Purchase Credit Limit</td>
	        <td class="odd"><input name='purchasecreditlimit' value="$this->purchasecreditlimit"></td>
           </tr>
           <tr>
            <td class="foot">Control Sales Credit Limit</td>
	        <td class="odd"><input type='checkbox' name='enforcesalescreditlimit' $enforcesalescreditlimitchecked></td>
            <td class="foot">Control Purchase Credit Limit</td>
	        <td class="odd"><input type='checkbox' name='enforcepurchasecreditlimit' $enforcepurchasecreditlimitchecked></td>
           </tr>
           <tr>
            <td class="foot">Current Sales Limit Status</td>
	        <td class="odd"><input name='currentsalescreditstatus' value="$this->currentsalescreditstatus"></td>
            <td class="foot">Current Purchase Limit Status</td>
	        <td class="odd"><input name='currentpurchasecreditstatus' value="$this->currentpurchasecreditstatus"></td>
           </tr>
           <tr>
            <td class="foot">Tax</td>
	        <td class="odd">$this->taxctrl</td>
            <td class="foot">Bank Name</td>
	        <td class="odd"><input name='bankname' value="$this->bankname"></td>
           </tr>
           <tr>
            <td class="foot">Bank Account Name</td>
	        <td class="odd"><input name='bankaccountname' value="$this->bankaccountname"></td>
            <td class="foot">Bank Account No</td>
	        <td class="odd"><input name='bankaccountno' value="$this->bankaccountno"></td>
           </tr>
       </tbody></table></td>
      </tr>
 
    </tbody>
  </table>
<table style="width:150px;"><tbody><td >$savectrl
	<input name="action" value="$action" type="hidden">
	<input name="token" value="$token" type="hidden"></form></td>
    <td>$deletectrl</td><td>$recordctrl</td>
	</tbody></table>
	
  <br>

EOF;
  } // end of member function getInputForm

  public function viewBpartnerInfo( ) {
		$mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";

	$orgctrl="";
	$this->created=0;
	

	
		$editctrl="<input name='bpartner_id' value='$this->bpartner_id' type='hidden'>".
			 "<input style='height: 40px;' name='submit' value='Edit' type='submit'>";



		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='recordinfo.php' method='POST'>".
		"<input name='tablename' value='$this->tablebpartner' type='hidden'>".
		"<input name='id' value='$this->bpartner_id' type='hidden'>".
		"<input name='idname' value='bpartner_id' type='hidden'>".
		"<input name='title' value='BPartner' type='hidden'>".
		"<input name='submit' value='View Record Info' type='submit'>".
		"</form>";


		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";

		if ($this->isdebtor==1)
			$isdebtorchecked="CHECKED";
		else
			$isdebtorchecked="";

		if ($this->iscreditor==1)
			$iscreditorchecked="CHECKED";
		else
			$iscreditorchecked="";

		if ($this->istransporter==1)
			$istransporterchecked="CHECKED";
		else
			$istransporterchecked="";

		if ($this->isdealer==1)
			$isdealerchecked="CHECKED";
		else
			$isdealerchecked="";

		if ($this->isprospect==1)
			$isprospectchecked="CHECKED";
		else
			$isprospectchecked="";

		if ($this->enforcesalescreditlimit==1)
			$enforcesalescreditlimitchecked="CHECKED";
		else
			$enforcesalescreditlimitchecked="";

		if ($this->enforcepurchasecreditlimit==1)
			$enforcepurchasecreditlimitchecked="CHECKED";
		else
			$enforcepurchasecreditlimitchecked="";

		$header="View Business Partner Info";


    echo <<< EOF

<form onsubmit="return validateBPartner()" method="post"
 action="bpartner.php" name="frmBPartner"><table style="width:140px;"><tbody><td><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1">
    <tbody>
      <tr>
        <th colspan="4" rowspan="1">$header</th>
      </tr>
      <tr>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
   	<td class="head">Business Partner Group $mandatorysign</td>
        <td class="even" >$this->bpartnergroup_name</td>
      </tr>
      <tr>
       <td class="head">Business Partner No $mandatorysign</td>
        <td class="even" >$this->bpartner_no
	&nbsp;Active <input type="checkbox" $checked name="isactive" disabled='disabled'>
        Default Level $mandatorysign =$this->defaultlevel
        <td class="head">Business Partner Name $mandatorysign</td>
        <td class="even" >$this->bpartner_name</td>
      </tr>

      <tr>
    	<td class="head">Company No</td>
	    <td class="even" >$this->companyno</td>
        <td class="head">Alternate Name</td>
	    <td class="even" >$this->alternatename</td>
      </tr>
      <tr>
    	<td class="head">Industry</td>
	    <td class="even" >$this->industry_name</td>
        <td class="head">Employee Quantity</td>
	    <td class="even" >$this->employeecount</td>
      </tr>
     <tr>
    	<td class="head">Is Debtor (Customer)</td>
	    <td class="even" ><input type='checkbox' name='isdebtor' $isdebtorchecked disabled='disabled'></td>
        <td class="head">Is Creditor (Supplier)</td>
	    <td class="even" ><input type='checkbox' name='iscreditor' $iscreditorchecked disabled='disabled'></td>
      </tr>
     <tr>
    	<td class="head">Is Transporter</td>
	    <td class="even" ><input type='checkbox' name='istransporter' $istransporterchecked disabled='disabled'></td>
        <td class="head">Is Dealer</td>
	    <td class="even" ><input type='checkbox' name='isdealer' $isdealerchecked disabled='disabled'></td>
      </tr>
     <tr>
    	<td class="head">Is Prospect</td>
	    <td class="even" ><input type='checkbox' name='isprospect' $isprospectchecked disabled='disabled'></td>
        <td class="head">Terms</td>
	    <td class="even" >$this->terms_name</td>
      </tr>

       <tr>
        <td class="head">Tooltips</td>
	    <td class="even">$this->tooltips</td>
        <td class="head">Website</td>
	    <td class="even">$this->bpartner_url</td>
      </tr>
      <tr>
        <td class="head">Description</td>
	    <td class="even" colspan='3'>$this->description</td>
      </tr>
      <tr>
        <td class="head">Currency</td>
        <td class="even" >$this->currency_code</td>
    	<td class="head"></td>
    	<td class="even" >
               
        </td>
      </tr>
    

    </tbody>
  </table>
<table style="width:150px;"><tbody><td>$editctrl
	<input name="action" value="edit" type="hidden">
</form></td>
   <td>$recordctrl</td>
	</tbody></table>

  <br>

EOF;
  }
  /**
   * Update existing bpartner record
   *
   * @return bool
   * @access public
   */
  public function updateBPartner( ) {



 	$sql="UPDATE $this->tablebpartner SET 
	bpartner_id=$this->bpartner_id,
	bpartnergroup_id=$this->bpartnergroup_id,
	bpartner_no='$this->bpartner_no',
	bpartner_name='$this->bpartner_name',
	isactive=$this->isactive,
	defaultlevel=$this->defaultlevel,
	updated='$this->updated',
	updatedby=$this->updatedby,
	currency_id=$this->currency_id,
	terms_id=$this->terms_id,
	salescreditlimit=$this->salescreditlimit,
	organization_id=$this->organization_id,
	bpartner_url='$this->bpartner_url',
	debtoraccounts_id=$this->debtoraccounts_id,
	description='$this->description',
	tax_id=$this->tax_id,
	creditoraccounts_id=$this->creditoraccounts_id,
	isdebtor=$this->isdebtor,
	iscreditor=$this->iscreditor,
	istransporter=$this->istransporter,
	purchasecreditlimit=$this->purchasecreditlimit,
	enforcesalescreditlimit=$this->enforcesalescreditlimit,
	enforcepurchasecreditlimit=$this->enforcepurchasecreditlimit,
	currentsalescreditstatus=$this->currentsalescreditstatus,
	currentpurchasecreditstatus=$this->currentpurchasecreditstatus,
	bankaccountname='$this->bankaccountname',
	bankname='$this->bankname',
	bankaccountno='$this->bankaccountno',
	isdealer=$this->isdealer,
	isprospect=$this->isprospect,
	employeecount=$this->employeecount,
	alternatename='$this->alternatename',
	companyno='$this->companyno',
	industry_id=$this->industry_id,
    tooltips='$this->tooltips'
	 WHERE bpartner_id='$this->bpartner_id'";
	$this->updatesql=$sql;
	$this->log->showLog(3, "Update bpartner_id: $this->bpartner_id, $this->bpartner_name");
	$this->log->showLog(4, "Before execute SQL statement:$sql");
	
	$rs=$this->xoopsDB->query($sql);
	if(!$rs){
      
		$this->log->showLog(2, "Warning! Update bpartner failed:".mysql_error(). ":$sql");
		return false;
	}
	else{

		$this->log->showLog(3, "Update bpartner successfully.");
		return true;
	}
  } // end of member function updateBPartner

  /**
   * Save new bpartner into database
   *
   * @return bool
   * @access public
   */
  public function insertBPartner( ) {
   include "../simantz/class/Save_Data.inc.php";
   $save = new Save_Data();
     //do your sql insert here using $this->employee_name method : return boolean true or false
            global $xoopsDB,$xoopsUser;
            $joindate=date("Y-m-d",time());
            $timestamp=date("Y-m-d H:i:s",time());
            $createdby=$xoopsUser->getVar('uid');
            $uname=$xoopsUser->getVar('uname');
            $this->updatedby=$xoopsUser->getVar('uid');
            $tablename="sim_bpartner";
            
 if($this->bpartner_id > 0){//do update sql here

      $this->arrUpdateField=array("employeecount,alternatename,companyno,industry_id,tooltips,
                            bpartnergroup_id,bpartner_no,bpartner_name,isactive,bpartner_url,

                            description,currency_id,terms_id,organization_id,defaultlevel,
                            updated,updatedby");

    $this->arrUpdateFieldType=array("%d","%s","%s","%d","%s",
                                    "%d","%s","%s","%d","%s",

                                    "%s","%d","%d","%d","%d",
                                    "%s","%d","%d");
    
 $arrvalue=array($this->employeecount,$this->alternatename,$this->companyno,$this->industry_id,$this->tooltips,
                 $this->bpartnergroup_id,$this->bpartner_no,$this->bpartner_name,$this->isactive,$this->bpartner_url,

                 $this->description,0,0,$this->organization_id,$this->defaultlevel,
	         $this->updated,$this->updatedby);

    return $save->UpdateRecord($tablename, "bpartner_id", $this->bpartner_id, $this->arrUpdateField, $arrvalue,  $this->arrUpdateFieldType,$this->bpartner_no);

     }else{//do insert sql here

   $this->arrInsertField=array("employeecount,alternatename,companyno,industry_id,tooltips,
                            bpartnergroup_id,bpartner_no,bpartner_name,isactive,bpartner_url,

                            description,currency_id,terms_id,organization_id,defaultlevel,
                            created,createdby,updated,updatedby");

   $this->arrInsertFieldType=array("%d","%s","%s","%d","%s",
                                    "%d","%s","%s","%d","%s",

                                    "%s","%d","%d","%d","%d",
                                    "%s","%d","%s","%d","%d");
    $arrvalue=array($this->employeecount,$this->alternatename,$this->companyno,$this->industry_id,$this->tooltips,
                 $this->bpartnergroup_id,$this->bpartner_no,$this->bpartner_name,$this->isactive,$this->bpartner_url,

                 $this->description,0,0,$this->organization_id,$this->defaultlevel,
	         $this->created,$this->createdby,$this->updated,$this->updatedby);

 return $save->InsertRecord($tablename, $this->arrInsertField, $arrvalue, $this->arrInsertFieldType, $this->bpartner_name,"bpartner_id");

   }
 }
 // end of member function insertBPartner

  /**
   * Pull data from bpartner table into class
   *
   * @return bool
   * @access public
   */
  public function fetchBPartner( $bpartner_id) {

	$this->log->showLog(3,"Fetching bpartner detail into class BPartner.php.<br>");
		
	$sql="SELECT
    bp.bpartner_id,
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
    cr.currency_code,
    cr.currency_name,
    tm.terms_name,
    i.industry_name,
    bpg.bpartnergroup_name
	from $this->tablebpartner bp 
	INNER JOIN $this->tablecurrency cr on bp.currency_id=cr.currency_id 
	INNER JOIN $this->tableterms tm on tm.terms_id=bp.terms_id
	INNER JOIN $this->tablebpartnergroup bpg on bpg.bpartnergroup_id=bp.bpartnergroup_id
    INNER JOIN $this->tableindustry i on i.industry_id=bp.industry_id
	where bp.bpartner_id=$bpartner_id";
	
	$this->log->showLog(4,"ProductBPartner->fetchBPartner, before execute:" . $sql . "<br>");
	
	$query=$this->xoopsDB->query($sql);
	
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->bpartner_id=$row['bpartner_id'];
	$this->bpartnergroup_id=$row['bpartnergroup_id'];
	$this->bpartner_no=$row['bpartner_no'];
	$this->bpartner_name=$row['bpartner_name'];
	$this->isactive=$row['isactive'];
	$this->defaultlevel=$row['defaultlevel'];
	$this->created=$row['created'];
	$this->createdby=$row['createdby'];
	$this->updated=$row['updated'];
	$this->updatedby=$row['updatedby'];
	$this->currency_id=$row['currency_id'];
	$this->terms_id=$row['terms_id'];
	$this->salescreditlimit=$row['salescreditlimit'];
	$this->organization_id=$row['organization_id'];
	$this->bpartner_url=$row['bpartner_url'];
	$this->debtoraccounts_id=$row['debtoraccounts_id'];
	$this->description=$row['description'];
	$this->tax_id=$row['tax_id'];
	$this->currentbalance=$row['currentbalance'];
	$this->creditoraccounts_id=$row['creditoraccounts_id'];
	$this->isdebtor=$row['isdebtor'];
	$this->iscreditor=$row['iscreditor'];
	$this->istransporter=$row['istransporter'];
	$this->purchasecreditlimit=$row['purchasecreditlimit'];
	$this->enforcesalescreditlimit=$row['enforcesalescreditlimit'];
	$this->enforcepurchasecreditlimit=$row['enforcepurchasecreditlimit'];
	$this->currentsalescreditstatus=$row['currentsalescreditstatus'];
	$this->currentpurchasecreditstatus=$row['currentpurchasecreditstatus'];
	$this->bankaccountname=$row['bankaccountname'];
	$this->bankname=$row['bankname'];
	$this->bankaccountno=$row['bankaccountno'];
	$this->isdealer=$row['isdealer'];
	$this->isprospect=$row['isprospect'];
	$this->employeecount=$row['employeecount'];
	$this->alternatename=$row['alternatename'];
	$this->companyno=$row['companyno'];
	$this->industry_id=$row['industry_id'];
    $this->tooltips=$row['tooltips'];
	$this->terms_name=$row['terms_name'];
    $this->bpartnergroup_name=$row['bpartnergroup_name'];
    $this->currency_code=$row['currency_code'];
    $this->industry_name=$row['industry_name'];
   	$this->log->showLog(4,"BPartner->fetchBPartner,database fetch into class successfully");
	$this->log->showLog(4,"bpartner_name:$this->bpartner_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
  //      exit(0);
		return false;
	$this->log->showLog(4,"BPartner->fetchBPartner,failed to fetch data into databases:" . mysql_error(). ":$sql");	
	}
  } // end of member function fetchBPartner

  /**
   * Delete particular bpartner id
   *
   * @param int bpartner_id 
   * @return bool
   * @access public
   */
  public function deleteBPartner( $bpartner_id ) {
    	$this->log->showLog(2,"Warning: Performing delete bpartner id : $bpartner_id !");
	$sql="DELETE FROM $this->tablebpartner where bpartner_id=$bpartner_id";
	$this->log->showLog(4,"Delete SQL Statement: $sql");
	$this->updatesql=$sql;
	$rs=$this->xoopsDB->query($sql);
	if (!$rs){
		$this->log->showLog(1,"Error: bpartner ($bpartner_id) cannot remove from database:" . mysql_error(). ":$sql");
		return false;
	}
	else{
		$this->log->showLog(3,"bpartner ($bpartner_id) removed from database successfully!");
		return true;
		
	}
  } // end of member function deleteBPartner

  /**
   * Return select sql statement.
   *
   * @param string wherestring 
   * @param string orderbystring 
   * @param int startlimitno 
   * @return string
   * @access public
   */
  public function getSQLStr_AllBPartner( $wherestring,  $orderbystring,$limit="") {
  $this->log->showLog(4,"Running ProductBPartner->getSQLStr_AllBPartner: $sql");

    $sql="SELECT bp.bpartner_name,bp.bpartner_no,bp.bpartner_id,bp.isactive,
		bp.organization_id,bp.defaultlevel,bp.bpartnergroup_id,
		tm.terms_name,bp.salescreditlimit,bp.tooltips
		FROM $this->tablebpartner bp
		INNER JOIN $this->tableterms tm on bp.terms_id=tm.terms_id
	$wherestring $orderbystring $limit";
    $this->log->showLog(4,"Generate showbpartnertable with sql:$sql");
	
  return $sql;
  } // end of member function getSQLStr_AllBPartner

 public function showBPartnerTable($wherestring,$orderbystring,$limit=""){
	
	$this->log->showLog(3,"Showing BPartner Table");
	$sql=$this->getSQLStr_AllBPartner($wherestring,$orderbystring,$limit);
	
	$wherestring = str_replace("'","~",$wherestring);
	$query=$this->xoopsDB->query($sql);
	echo <<< EOF
	<div id="idListHTML">
	<form name="frmSearchForm" >
	<table border='1' cellspacing='3'>
  		<tbody>
		<input type="hidden" name="wherestr" value="$wherestring">
	<tr>
		
		<th style="text-align:center;">No</th>
		<th style="text-align:center;">Business Partner No 
		<image id="ids_bpartner_id" src="images/sortdown.gif" onclick="sortList(this.id)">
		<input type="hidden" name="ids_bpartner_id">
		</th>
		<th style="text-align:center;">Business Partner Name
		<image id="ids_bpartner_name" src="images/sortdown.gif" onclick="sortList(this.id)">
		<input type="hidden" name="ids_bpartner_name">
		</th>
		<th style="text-align:center;">Terms</th>
		<th style="text-align:center;">Credit Limit
		<image id="ids_creditlimit" src="images/sortdown.gif" onclick="sortList(this.id)">
		<input type="hidden" name="ids_creditlimit">
		</th>
		<th style="text-align:center;"></th>
   	</tr>
		
	</form>
	
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$bpartner_id=$row['bpartner_id'];
		$bpartner_name=$row['bpartner_name'];
		$bpartner_no=$row['bpartner_no'];
		$defaultlevel=$row['defaultlevel'];
		$bpartnergroup_id=$row['bpartnergroup_id'];
		$terms_name=$row['terms_name'];
		$isactive=$row['isactive'];
		$salescreditlimit=$row['salescreditlimit'];
        $tooltips=$row['tooltips'];

		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
		}
		else
		$isactive='Y';

		if($bpartnergroup_id==0)
			$bpartnergroup_id="N";
		else
			$bpartnergroup_id='Y';

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		echo <<< EOF

		<tr>
			<td class="$rowtype" style="text-align:center;">$i</td>
			<td class="$rowtype" style="text-align:center;">$bpartner_no</td>

			<td class="$rowtype" style="text-align:left;">
                <a href="bpartner.php?action=view&bpartner_id=$bpartner_id" title='$tooltips'
                    title='$tooltips'>$bpartner_name</a>
            </td>
			<td class="$rowtype" style="text-align:center;">$terms_name</td>
			<td class="$rowtype" style="text-align:center;">$salescreditlimit</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="bpartner.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title="Edit this Record">
				<input type="hidden" value="$bpartner_id" name="bpartner_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>

		</tr>

	
EOF;
	}
	echo  "</tbody></table></div>";
 }

 public function sortList($wherestring,$orderbystring,$fld_sort){
	
	$this->log->showLog(3,"Showing BPartner Table");
	$sql=$this->getSQLStr_AllBPartner($wherestring,$orderbystring,$limit);
	$innerHTML = "";

	$wherestring = str_replace("'","~",$wherestring);

	$query=$this->xoopsDB->query($sql);

	$innerHTML .= "<form name='frmSearchForm' >";
	$innerHTML .= "<table border='1' cellspacing='3'>";
	$innerHTML .= "<tbody>";
	$innerHTML .= "<input type='hidden' name='wherestr' value='$wherestring'>";
	$innerHTML .= "<tr>";
	$innerHTML .= "<th style='text-align:center;'>No</th>";
	$innerHTML .= "<th style='text-align:center;' nowrap>Business Partner No ";
	$innerHTML .= "<image id='ids_bpartner_id' src='images/sortdown.gif' onclick='sortList(this.id)'>";
	$innerHTML .= "<input type='hidden' name='ids_bpartner_id'>";
	$innerHTML .= "</th>";
	$innerHTML .= "<th style='text-align:center;' nowrap>Business Partner Name";
	$innerHTML .= "<image id='ids_bpartner_name' src='images/sortdown.gif' onclick='sortList(this.id)'>";
	$innerHTML .= "<input type='hidden' name='ids_bpartner_name'>";
	$innerHTML .= "</th>";
	$innerHTML .= "<th style='text-align:center;'>Terms";
	$innerHTML .= "</th>";
	$innerHTML .= "<th style='text-align:center;' nowrap>Credit Limit";
	$innerHTML .= "<image id='ids_creditlimit' src='images/sortdown.gif' onclick='sortList(this.id)'>";
	$innerHTML .= "<input type='hidden' name='ids_creditlimit'>";
	$innerHTML .= "</th>";
	$innerHTML .= "<th style='text-align:center;'>City</th>";
	$innerHTML .= "<th style='text-align:center;'>Tel</th>";
	$innerHTML .= "<th style='text-align:center;'>Fax</th>";
	$innerHTML .= "<th style='text-align:center;'>HP</th>";
	$innerHTML .= "<th style='text-align:center;'>Email</th>";
	$innerHTML .= "<th style='text-align:center;' nowrap>Contact Person</th>";
	$innerHTML .= "<th style='text-align:center;'></th>";
   	$innerHTML .= "</tr>";
	$innerHTML .= "</form>";
	

	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$bpartner_id=$row['bpartner_id'];
		$bpartner_name=$row['bpartner_name'];
		$bpartner_no=$row['bpartner_no'];
		$defaultlevel=$row['defaultlevel'];
		$bpartnergroup_id=$row['bpartnergroup_id'];
		$terms_name=$row['terms_name'];
		$isactive=$row['isactive'];
		$tooltips=$row['tooltips'];


		if($isactive==0)
		{$isactive='N';
		$isactive="<b style='color:red;'>N</b>";
		}
		else
		$isactive='Y';

		if($bpartnergroup_id==0)
			$bpartnergroup_id="N";
		else
			$bpartnergroup_id='Y';

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
		
		$innerHTML .= "<tr>";
		$innerHTML .= "<td class='$rowtype' style='text-align:center;'>$i</td>";
		$innerHTML .= "<td class='$rowtype' style='text-align:center;'>$bpartner_no</td>";
		$innerHTML .= "<td class='$rowtype' style='text-align:left;'>";
		$innerHTML .= "<a href='bpartner.php?action=view&bpartner_id=$bpartner_id' title='$tooltips'>$bpartner_name</a></td>";
		$innerHTML .= "<td class='$rowtype' style='text-align:center;'>$terms_name</td>";
		$innerHTML .= "<td class='$rowtype' style='text-align:center;'>$creditlimit</td>";
		$innerHTML .= "<td class='$rowtype' style='text-align:center;'>";
		$innerHTML .= "<form action='bpartner.php' method='POST'>";
		$innerHTML .= "<input type='image' src='images/edit.gif' name='submit' title='Edit this Record'>";
		$innerHTML .= "<input type='hidden' value='$bpartner_id' name='bpartner_id'>";
		$innerHTML .= "<input type='hidden' name='action' value='edit'>";
		$innerHTML .= "</form>";
		$innerHTML .= "</td>";
		$innerHTML .= "</tr>";

	}

	$innerHTML .= "</tbody></table>";
	

	return $innerHTML;

 }
/**
 * 
   *
   * @return int
   * @access public
   */
  public function getLatestBPartnerID() {
	$sql="SELECT MAX(bpartner_id) as bpartner_id from $this->tablebpartner;";
	$this->log->showLog(3,'Checking latest created bpartner_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created bpartner_id:' . $row['bpartner_id']);
		return $row['bpartner_id'];
	}
	else
	return -1;
	
  } // end


  public function getNextSeqNo() {

	$sql="SELECT MAX(defaultlevel) + 10 as defaultlevel from $this->tablebpartner;";
	$this->log->showLog(3,'Checking next defaultlevel');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next defaultlevel:' . $row['defaultlevel']);
		return  $row['defaultlevel'];
	}
	else
	return 10;
	
  } // end

 public function allowDelete($bpartner_id){
	/*
	$sql="SELECT count(bpartner_id) as rowcount from $this->tablebpartner where bpartnergroup_id=$bpartner_id";
	$this->log->showLog(3,"Accessing ProductCurrency->allowDelete to verified id:$id is deletable.");
	$this->log->showLog(4,"SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query))
		if( $row['rowcount']>0)
			{
			$this->log->showLog(3, $row['rowcount'] . " record found in this currency, record not deletable");
			return false;
			}
	else
		{
		$this->log->showLog(3,"No record under this currency, record deletable.");
		return true;
		}*/
	return true;
	}

public function searchAToZ(){
	global $defaultorganization_id;
	$this->log->showLog(3,"Prepare to provide a shortcut for user to search student easily. With function searchAToZ()");
	$sqlfilter=	"SELECT DISTINCT(LEFT(bpartner_name,1)) as shortname FROM $this->tablebpartner 
			where isactive=1 and bpartner_id>0 
			and organization_id = $defaultorganization_id 
			order by bpartner_name";
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
echo "<b>Business Partner Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$shortname=$row['shortname'];
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if customer never do filter yet, if will choose 1st customer listing
		
		echo "<A href='bpartner.php?filterstring=$shortname'> $shortname </A> ";
	}

		echo "<A href='bpartner.php?filterstring=all'> -<u>Show All</u>- </A> ";
		echo <<<EOF
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


EOF;
return $filterstring;

	$this->log->showLog(3,"Complete generate list of short cut");
  }


  	public function getDefaultAccount($id){
	$retval = 0;

	$sql = "select * from $this->tablebpartnergroup where bpartnergroup_id = $id ";

	$this->log->showLog(4,"SQL: $sql");

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
	$this->defdebtoraccounts_id=$row['debtoraccounts_id'];
	$this->defcreditoraccounts_id=$row['creditoraccounts_id'];
	$retval = true;
	}
	else
	$retval=false;

	return $retval;

	
	}


	public function showSearchForm(){
	$yes = "";
	$no = "";
	$null = "";

	if($this->isactive == 1)
	$yes = "SELECTED";
	else if($this->isactive == "")
	$null = "SELECTED";
	else if($this->isactive == 0)
	$no = "SELECTED";
	
//	echo "No : ".$no." Yes :".$yes." Null :".$null;
	
echo <<< EOF

	<!--<A href='bpartner.php' style='color: GRAY'> [ADD NEW BUSINESS PARTNER]</A>-->
	<form action="bpartner.php" method="POST" name="frmSearch">
	
	<table border=1>
	<input type=hidden name="issearch" value="1">
	<input type=hidden name="action" value="search">
	<tr>
	<th colspan="4">Search Criteria</th>
	</tr>
	
	<tr>
	<td class="head">Business Partner No (100%, %10,%1001%)</td>
	<td class="even" colspan="3"><input name="bpartner_no" value="$this->bpartner_no"></td>
	</tr>

	<tr>
	<td class="head">Business Partner Name</td>
	<td class="even"><input name="bpartner_name" value="$this->bpartner_name" size="35"></td>
	<td class="head">Business Partner Group</td>
	<td class="even">$this->bpartnergroupctrl</td>
	</tr>
	
	<tr>
	<td class="head">City</td>
	<td class="even"><input name="bpartner_city" value="$this->bpartner_city"></td>
	<td class="head">Contact Person</td>
	<td class="even"><input name="contactperson1" value="$this->contactperson1" size="35"></td>
	</tr>
	
	<tr>
	<td class="head">HP No</td>
	<td class="even"><input name="bpartner_hp_no1" value="$this->bpartner_hp_no1"></td>
	<td class="head">Active</td>
	<td class="even" acolspan="3">
	<select name="isactive">
	<option value="" $null></option>
	<option value="1" $yes>Yes</option>
	<option value="0" $no>No</option>
	</select>
	</td>
	</tr>
	
	<tr>
	<td><input type="reset" value="Reset"></td>
	<td colspan="3"><input type="submit" value="Search"></td>
	</tr>
	
	</table>
	
	</form>
EOF;
	}
	
	
	public function getWhereStr(){
	$wherestr = "";

	if($this->bpartner_no != "")
	$wherestr .= " and bpartner_no like '$this->bpartner_no' ";
	
	if($this->bpartner_name != "")
	$wherestr .= " and bpartner_name like '$this->bpartner_name' ";

	if($this->bpartner_city != "")
	$wherestr .= " and bpartner_city like '$this->bpartner_city' ";

	if($this->contactperson1 != "")
	$wherestr .= " and (contactperson1 like '$this->contactperson1' or contactperson2 like '$this->contactperson1') ";


	if($this->bpartner_hp_no1 != 0)
	$wherestr .= " and (bpartner_hp_no1 like '$this->bpartner_hp_no1' or bpartner_hp_no2 like '$this->bpartner_hp_no1') ";

	if($this->bpartnergroup_id > 0)
	$wherestr .= " and bpartnergroup_id = $this->bpartnergroup_id ";

	

	if($this->isactive != "")
	$wherestr .= " and bp.isactive = $this->isactive ";

	
	return $wherestr;
	}
} // end of ClassBPartner
?>

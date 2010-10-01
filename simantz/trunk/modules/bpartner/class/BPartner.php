<?php


class BPartner
{
  public	$bpartner_id;
  public	$bpartnergroup_id;
  public	$bpartner_no;
  public	$bpartner_name;
  public	$isactive;
  public	$seqno;
  public	$created;
  public	$createdby;
  public	$updated;
  public	$updatedby;
  public	$currency_id;
  public	$shortremarks;
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
  public    $employee_id;
  public    $pricelist_id;
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
            $tablecountry,$tablecurrency,$tableterms,$tableindustry,$tableemployee,$tablepricelist;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablebpartner=$tablebpartner;
	$this->tablebpartnergroup=$tablebpartnergroup;
    $this->tableindustry=$tableindustry;
	$this->tableaccounts=$tableaccounts;
	$this->tablecountry=$tablecountry;
	$this->tableterms=$tableterms;
	$this->tablecurrency=$tablecurrency;
    $this->tableemployee=$tableemployee;
    $this->tablepricelist=$tablepricelist;
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
	global $havewriteperm, $showOrganization, $isadmin;
      $mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";
	$savectrl="";
	$deletectrl="";
	$itemselect="";

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New Business Partner";
		$action="create";

		if($bpartner_id==0){
			$this->bpartner_name="";
			$this->isactive=1;
			$this->seqno=10;
            $this->employeecount=0;
            $this->currentpurchasecreditstatus=0;
            $this->currentbalance=0;
            $this->currentsalescreditstatus=0;
            $this->salescreditlimit=0;
            $this->purchasecreditlimit=0;


		}
		$savectrl="<input style='height: 40px;' name='submit' value='Save' type='submit'>";
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

if($havewriteperm==1){ //user with write permission can edit data, have button
   $savectrl="<input astyle='height: 40px;' name='btnsubmit' value='Save and Add More Details' type='button' onclick='validateBPartner()'>";
   $saveandnewctrl="<input astyle='height: 80px;' name='btnsaveonly' value='Save and Add New' type='submit' onclick='saveonly();validateBPartner();'>";
}
else{ //user dun have write permission, cannot save grid
   $savectrl="";
   $saveandnewctrl="";
   $noperm="<div>You No Have Write Permission</div>";
}
    $search_button = $this->getFormButton("Search","bpartner.php",array("action"=>"search") );
    $new_button = $this->getFormButton("New","bpartner.php");

   if($showOrganization!=1)
        $hideOganization="style='display:none'";
   else
        $hideOganization="";

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
   function saveonly()
   {
    document.getElementById("isaddnew").value=1;
   }

     function validateBPartner(){

     if(confirm("Confirm to save record?")){
         //start form validation
            var bpartner_no = document.getElementById('bpartner_no').value;
            var bpartner_name = document.getElementById('bpartner_name').value;
            var bpartnergroup_id = document.getElementById('bpartnergroup_id').value;

//            $("#bpartner_no").removeClass('validatefail');
//            $("#bpartner_name").removeClass('validatefail');
//            $("#bpartnergroup_id").removeClass('validatefail');

            var isallow = true;
            var errorMsg = "";
            if(bpartner_no == ""){
                isallow = false;
                errorMsg += "<br/><b>Business Partner No </b>";
//                         $("#bpartner_no").addClass('validatefail');
            }

            if(bpartner_name == ""){
                isallow = false;
                errorMsg += "<br/><b>Business Partner Name</b>";
//                         $("#bpartner_name").addClass('validatefail');
            }

            if(bpartnergroup_id == "0" || bpartnergroup_id == ""){
                isallow = false;
                errorMsg += "<br/><b>Business Partner Group</b>";
//                         $("#bpartnergroup_id").addClass('validatefail');
            }

             if(isallow){
             document.frmBPartner.submit();
              }else{
                 document.getElementById("statusDiv").innerHTML="Failed to save record...Please Check :<br/>"+errorMsg;
                 return false;
               }
         }
         else
         return false;
     }

</script>

 <div id="statusDiv" align="center" class="ErrorstatusDiv">$noperm</div>
   <table style="width: 970px;"  align="center">
    <tr>
    <td width="60px">$search_button</td>
    <td align="left">$new_button</td>
    </tr>
  </table>
<form method="post" action="bpartner.php" name="frmBPartner" id="frmBPartner" enctype="multipart/form-data" onsubmit="return false">
<input type="hidden" name="action" value="bpartner">
<input type="hidden" name="mode" value="save">
<input type="hidden" name="isaddnew" id="isaddnew" value="0">
<input type="hidden" name="bpartner_id" value="0">

  <table style="text-align:left; width:970px;" align="center" border="0" cellpadding="0" cellspacing="1" >

      <tr>
        <td colspan="4" rowspan="1" class="searchformheader">$header</td>
      </tr>

      <tr><td class="searchformblock">
        <table >

      <tr $hideOganization>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>

      </tr>

      <tr>
       <td class="head">Business Partner No $mandatorysign</td>
        <td class="even" ><input maxlength="10" size="10" name="bpartner_no" id="bpartner_no" value="$this->bpartner_no">
	&nbsp;Active <input type="checkbox" $checked name="isactive" id="isactive"> Default Level $mandatorysign <input maxlength="3" size="3" name='seqno' value='$this->seqno'>
   	<td class="head">Business Partner Group $mandatorysign</td>
          <td class="even" >
            <select name="bpartnergroup_id" id="bpartnergroup_id">
               $this->bpartnergroupctrl
            </select></td>
      </tr>

      <tr>
    	<td class="head">Company No</td>
	    <td class="even" ><input name="companyno" id="companyno" value="$this->companyno"></td>
        <td class="head">Business Partner Name $mandatorysign</td>
          <td class="even" ><input maxlength="70" size="45" name="bpartner_name" id="bpartner_name" value="$this->bpartner_name"></td>
      </tr>

      <tr>
        <td class="head">Alternate Name</td>
	    <td class="even" ><input name="alternatename" id="alternatename" value="$this->alternatename"></td>
        <td class="head">Employee Count</td>
	    <td class="even" ><input name="employeecount" id="employeecount" value="$this->employeecount"></td>
      </tr>

      <tr>
    	<td class="head">Industry</td>
	    <td class="even" >
             <select name="industry_id" id="industry_id">
            $this->industryctrl
             </select>
            </td>

      </tr>

     <tr>
    	<td><br></td>
     </tr>

     <tr>
    	<td class="head">Is Debtor (Customer)</td>
	    <td class="even" ><input type="checkbox" name="isdebtor" id="isdebtor" $isdebtorchecked></td>
        <td class="head">Is Creditor (Supplier)</td>
	    <td class="even" ><input type="checkbox" name="iscreditor" id="iscreditor" $iscreditorchecked></td>
      </tr>
     <tr>
    	<td class="head">Is Transporter</td>
	    <td class="even" ><input type="checkbox" name="istransporter" id="istransporter" $istransporterchecked></td>
        <td class="head">Is Dealer</td>
	    <td class="even" ><input type="checkbox" name="isdealer" id="isdealer" $isdealerchecked></td>
      </tr>
     <tr>
    	<td class="head">Is Prospect</td>
	    <td class="even" ><input type="checkbox" name="isprospect" id="isprospect" $isprospectchecked></td>
           <td class="head">Currency</td>
        <td class="even" colspan="3"><select name="currency_id" id="currency_id">$this->currencyctrl</select > $this->pricelistctrl</td>
      </tr>

       <tr>
    	<td><br></td>
      </tr>


       <tr>
        <td class="head">Tooltips</td>
	    <td class="even"><input name="tooltips" id="tooltips" value="$this->tooltips" size="45"></td>
        <td class="head">Website</td>
	    <td class="even"><input name="bpartner_url" id="bpartner_url" value="$this->bpartner_url" size="45"></td>
      </tr>

      <tr>
       <td class="head">In Charge Person</td>
	    <td class="even"><input name="inchargeperson" id="inchargeperson" value="$this->inchargeperson " size="45"></td>
       <td class="head">Short Description</td>
            <td class="even"><input name="shortremarks" id="shortremarks" value="$this->shortremarks" size="45"></td>
      </tr>

      <tr>
        <td class="head" >Description</td>
	    <td class="even"><textarea cols="42" rows="6" name="description" id="description">$this->description</textarea></td>
      </tr>


           <tr><td><br></td></tr>

          <tr><td class="searchformheader" colspan="4">Accounting Parameter:</td></tr>

           <tr>
            <td class="head">Debtor Account</td>
	        <td class="even" id="iddebtoraccountsctrl">$this->debtoraccountsctrl<input type="hidden" name="previousaccounts_id" value="$this->debtoraccounts_id"></td>
            <td class="head">Creditor Account</td>
	        <td class="even" id="idcreditoraccountsctrl">$this->creditoraccountsctrl<input type="hidden" name="previousaccounts_id" value="$this->creditoraccounts_id"></td>
           </tr>
           <tr>
            <td class="head">Sales Credit Limit</td>
	        <td class="even"><input name="salescreditlimit" value="$this->salescreditlimit"></td>
            <td class="head">Purchase Credit Limit</td>
	        <td class="even"><input name="purchasecreditlimit" value="$this->purchasecreditlimit"></td>
           </tr>
           <tr>
            <td class="head">Control Sales Credit Limit</td>
	        <td class="even"><input type="checkbox" name="enforcesalescreditlimit" $enforcesalescreditlimitchecked></td>
            <td class="head">Control Purchase Credit Limit</td>
	        <td class="even"><input type="checkbox" name="enforcepurchasecreditlimit" $enforcepurchasecreditlimitchecked></td>
           </tr>
           <tr>
            <td class="head">Current Sales Limit Status</td>
	        <td class="even"><input name="currentsalescreditstatus" value="$this->currentsalescreditstatus"></td>
            <td class="head">Current Purchase Limit Status</td>
	        <td class="even"><input name="currentpurchasecreditstatus" value="$this->currentpurchasecreditstatus"></td>
           </tr>
           <tr>
          <td class="head">Terms</td>
	    <td class="even" >
               <select name="terms_id" id="terms_id>
                  $this->termsctrl
               </select></td>
            <td class="head">Bank Name</td>
	        <td class="even"><input name="bankname" value="$this->bankname"></td>
           </tr>
           <tr>
            <td class="head">Bank Account Name</td>
	        <td class="even"><input name="bankaccountname" value="$this->bankaccountname"></td>
            <td class="head">Bank Account No</td>
	        <td class="even"><input name="bankaccountno" value="$this->bankaccountno"></td>
           </tr>

      <tr><td align="left" colspan="4"><br>$savectrl $saveandnewctrl</td>
              	<td class="head"></td>
       </tr>

      </table>
      </td></tr>

  </table>
</form>

EOF;
  } // end of member function getInputForm

  public function getBpartnerForm($bpartner_id) {
	global $havewriteperm, $showOrganization, $isadmin;
        $mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";

	$orgctrl="";
	$this->created=0;

		$mode="save";
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


if($havewriteperm==1){ //user with write permission can edit data, have button
   $savectrl="<input astyle='height: 40px;' name='btnsubmit' value='Save' type='button' onclick='validateBPartner()'>";
   $saveandnewctrl="<input astyle='height: 80px;' name='btnsaveonly' value='Save and Add New' type='submit' onclick='saveonly();validateBPartner();'>";
}
else{ //user dun have write permission, cannot save grid
   $savectrl="";
   $saveandnewctrl="";
   $noperm="<div>You No Have Write Permission</div>";
}
    $search_button = $this->getFormButton("Search","bpartner.php",array("action"=>"search") );
    $new_button = $this->getFormButton("New","bpartner.php");

   if($showOrganization!=1)
        $hideOganization="style='display:none'";
   else
        $hideOganization="";

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

     function validateBPartner(){

     if(confirm("Confirm to save record?")){
         //start form validation
            var bpartner_no = document.getElementById('bpartner_no').value;
            var bpartner_name = document.getElementById('bpartner_name').value;
            var bpartnergroup_id = document.getElementById('bpartnergroup_id').value;

            $("#bpartner_no").removeClass('validatefail');
            $("#bpartner_name").removeClass('validatefail');
            $("#bpartnergroup_id").removeClass('validatefail');

            var isallow = true;
            var errorMsg = "";
            if(bpartner_no == ""){
                isallow = false;
                errorMsg += "<br/><b>Business Partner No </b>";
                         $("#bpartner_no").addClass('validatefail');
            }

            if(bpartner_name == ""){
                isallow = false;
                errorMsg += "<br/><b>Business Partner Name</b>";
                         $("#bpartner_name").addClass('validatefail');
            }

            if(bpartnergroup_id == "0" || bpartnergroup_id == ""){
                isallow = false;
                errorMsg += "<br/><b>Business Partner Group</b>";
                         $("#bpartnergroup_id").addClass('validatefail');
            }

             if(isallow){
             document.frmBPartner.submit();
                                jsonObj = eval( '(' + xml + ')');

              }else{
                 document.getElementById("statusDiv").innerHTML="Failed to save record...Please Check :<br/>"+errorMsg;
                 return false;
               }
         }
         else
         return false;
     }

</script>

 <div id="statusDiv" align="center" class="ErrorstatusDiv">$noperm</div>

<form method="post" action="bpartner.php" name="frmBPartner" id="frmBPartner" enctype="multipart/form-data" onsubmit="return false">
<input type="hidden" name="action" value="bpartnerinfo">
<input type="hidden" name="mode" value="save">
<input type="hidden" name="isaddnew" id="isaddnew" value="0">
<input type="hidden" name="bpartner_id" value="$this->bpartner_id">

  <table style="text-align:left; width:970px;" align="center" border="0" cellpadding="0" cellspacing="1" >

      <tr>
        <td colspan="4" rowspan="1" class="searchformheader">$header</td>
      </tr>

      <tr><td class="searchformblock">
        <table >

      <tr $hideOganization>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>

      </tr>

      <tr>
       <td class="head">Business Partner No $mandatorysign</td>
        <td class="even" ><input maxlength="10" size="10" name="bpartner_no" id="bpartner_no" value="$this->bpartner_no">
	&nbsp;Active <input type="checkbox" $checked name="isactive" id="isactive"> Default Level $mandatorysign <input maxlength="3" size="3" name='seqno' value='$this->seqno'>
   	<td class="head">Business Partner Group $mandatorysign</td>
          <td class="even" >
            <select name="bpartnergroup_id" id="bpartnergroup_id">
               $this->bpartnergroupctrl
            </select></td>
      </tr>

      <tr>
    	<td class="head">Company No</td>
	    <td class="even" ><input name="companyno" id="companyno" value="$this->companyno"></td>
        <td class="head">Business Partner Name $mandatorysign</td>
          <td class="even" ><input class="" maxlength="70" size="45" name="bpartner_name" id="bpartner_name" value="$this->bpartner_name"></td>
      </tr>

      <tr>
        <td class="head">Alternate Name</td>
	    <td class="even" ><input name="alternatename" id="alternatename" value="$this->alternatename"></td>
        <td class="head">Employee Count</td>
	    <td class="even" ><input name="employeecount" id="employeecount" value="$this->employeecount"></td>
      </tr>

      <tr>
    	<td class="head">Industry</td>
	    <td class="even" >
             <select name="industry_id" id="industry_id">
            $this->industryctrl
             </select>
            </td>

      </tr>

     <tr>
    	<td><br></td>
     </tr>

     <tr>
    	<td class="head">Is Debtor (Customer)</td>
	    <td class="even" ><input type="checkbox" name="isdebtor" id="isdebtor" $isdebtorchecked></td>
        <td class="head">Is Creditor (Supplier)</td>
	    <td class="even" ><input type="checkbox" name="iscreditor" id="iscreditor" $iscreditorchecked></td>
      </tr>
     <tr>
    	<td class="head">Is Transporter</td>
	    <td class="even" ><input type="checkbox" name="istransporter" id="istransporter" $istransporterchecked></td>
        <td class="head">Is Dealer</td>
	    <td class="even" ><input type="checkbox" name="isdealer" id="isdealer" $isdealerchecked></td>
      </tr>
     <tr>
    	<td class="head">Is Prospect</td>
	    <td class="even" ><input type="checkbox" name="isprospect" id="isprospect" $isprospectchecked></td>
           <td class="head">Currency</td>
        <td class="even" colspan="3"><select name="currency_id" id="currency_id">$this->currencyctrl</select > $this->pricelistctrl</td>
      </tr>

       <tr>
    	<td><br></td>
      </tr>


       <tr>
        <td class="head">Tooltips</td>
	    <td class="even"><input name="tooltips" id="tooltips" value="$this->tooltips" size="45"></td>
        <td class="head">Website</td>
	    <td class="even"><input name="bpartner_url" id="bpartner_url" value="$this->bpartner_url" size="45"></td>
      </tr>

      <tr>
       <td class="head">In Charge Person</td>
	    <td class="even"><input name="inchargeperson" id="inchargeperson" value="$this->inchargeperson " size="45"></td>
       <td class="head">Short Description</td>
            <td class="even"><input name="shortremarks" id="shortremarks" value="$this->shortremarks" size="45"></td>
      </tr>

      <tr>
        <td class="head" >Description</td>
	    <td class="even"><textarea cols="42" rows="6" name="description" id="description">$this->description</textarea></td>
  
      </tr>

      <tr>
    	<td><br></td>
      </tr>

          <tr><td class="searchformheader" colspan="4">Accounting Parameter:</td></tr>

           <tr>
            <td class="head">Debtor Account</td>
	        <td class="even" id="iddebtoraccountsctrl">$this->debtoraccountsctrl<input type="hidden" name="previousaccounts_id" value="$this->debtoraccounts_id"></td>
            <td class="head">Creditor Account</td>
	        <td class="even" id="idcreditoraccountsctrl">$this->creditoraccountsctrl<input type="hidden" name="previousaccounts_id" value="$this->creditoraccounts_id"></td>
           </tr>
           <tr>
            <td class="head">Sales Credit Limit</td>
	        <td class="even"><input name="salescreditlimit" value="$this->salescreditlimit"></td>
            <td class="head">Purchase Credit Limit</td>
	        <td class="even"><input name="purchasecreditlimit" value="$this->purchasecreditlimit"></td>
           </tr>
           <tr>
            <td class="head">Control Sales Credit Limit</td>
	        <td class="even"><input type="checkbox" name="enforcesalescreditlimit" $enforcesalescreditlimitchecked></td>
            <td class="head">Control Purchase Credit Limit</td>
	        <td class="even"><input type="checkbox" name="enforcepurchasecreditlimit" $enforcepurchasecreditlimitchecked></td>
           </tr>
           <tr>
            <td class="head">Current Sales Limit Status</td>
	        <td class="even"><input name="currentsalescreditstatus" value="$this->currentsalescreditstatus"></td>
            <td class="head">Current Purchase Limit Status</td>
	        <td class="even"><input name="currentpurchasecreditstatus" value="$this->currentpurchasecreditstatus"></td>
           </tr>
           <tr>
          <td class="head">Terms</td>
	    <td class="even" >
             <select name="terms_id" id="terms_id" >
               $this->termsctrl
              </select></td>
            <td class="head">Bank Name</td>
	        <td class="even"><input name="bankname" value="$this->bankname"></td>
           </tr>
           <tr>
            <td class="head">Bank Account Name</td>
	        <td class="even"><input name="bankaccountname" value="$this->bankaccountname"></td>
            <td class="head">Bank Account No</td>
	        <td class="even"><input name="bankaccountno" value="$this->bankaccountno"></td>
           </tr>
       </tbody></table></td>
      </tr>

      <tr><td align="left"><br>$savectrl</td>
              	<td class="head"></td>
       </tr>


  </table>
</form>

EOF;
  } // end of member function getInputForm

  public function getBpartnerview($bpartner_id) {
	global $havewriteperm, $showOrganization, $isadmin;
        $mandatorysign="<b style='color:red'>*</b>";

    	$header=""; // parameter to display form header
	$action="";

	$orgctrl="";
	$this->created=0;

		$mode="save";
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
			$checked="Yes";
		else
			$checked="No";

		if ($this->isdebtor==1)
			$isdebtorchecked="Yes";
		else
			$isdebtorchecked="No";

		if ($this->iscreditor==1)
			$iscreditorchecked="Yes";
		else
			$iscreditorchecked="No";

		if ($this->istransporter==1)
			$istransporterchecked="Yes";
		else
			$istransporterchecked="No";

		if ($this->isdealer==1)
			$isdealerchecked="Yes";
		else
			$isdealerchecked="No";

		if ($this->isprospect==1)
			$isprospectchecked="Yes";
		else
			$isprospectchecked="No";

		if ($this->enforcesalescreditlimit==1)
			$enforcesalescreditlimitchecked="Yes";
		else
			$enforcesalescreditlimitchecked="No";

		if ($this->enforcepurchasecreditlimit==1)
			$enforcepurchasecreditlimitchecked="Yes";
		else
			$enforcepurchasecreditlimitchecked="No";

		$header="View Business Partner";

		if($this->allowDelete($this->bpartner_id))
		$deletectrl="<FORM action='bpartner.php' method='POST' onSubmit='return confirm(".
		'"confirm to remove this bpartner?"'.")'><input type='submit' value='Delete' name='submit'>".
		"<input type='hidden' value='$this->bpartner_id' name='bpartner_id'>".
		"<input type='hidden' value='delete' name='action'><input name='token' value='$token' type='hidden'></form>";
		else
		$deletectrl="";
		$addnewctrl="<Form action='bpartner.php' method='POST'><input name='submit' value='New' type='submit'></form>";


if($havewriteperm==1){ //user with write permission can edit data, have button
     $editctrl=$this->getFormButton("Edit","bpartner.php",array("action"=>"bpartnerinfo","mode"=>"edit","bpartner_id"=>"$this->bpartner_id"));
}
else{ //user dun have write permission, cannot save grid
   $editctrl="";
   $noperm="<div>You No Have Write Permission</div>";
}


   if($showOrganization!=1)
        $hideOganization="style='display:none'";
   else
        $hideOganization="";

    echo <<< EOF
<script type='text/javascript'>

</script>

 <div id="statusDiv" align="center" class="ErrorstatusDiv">$noperm</div>

<form method="post" action="bpartner.php" name="frmBPartner" id="frmBPartner" enctype="multipart/form-data" onsubmit="return false">
<input type="hidden" name="action" value="bpartnerinfo">
<input type="hidden" name="mode" value="save">
<input type="hidden" name="bpartner_id" value="$this->bpartner_id">

  <table style="text-align:left; width:970px;" align="center" border="0" cellpadding="0" cellspacing="1" >

      <tr>
        <td colspan="4" rowspan="1" class="searchformheader">$header</td>
      </tr>

      <tr><td class="searchformblock">
        <table >

      <tr $hideOganization>
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>

      </tr>

      <tr>
       <td class="head">Business Partner No $mandatorysign</td>
        <td class="even" >$this->bpartner_no</td>
	<td class="head">Business Partner Group $mandatorysign</td>
          <td class="even" >
               $this->bpartnergroup_name </td>
      </tr>

      <tr>
    	<td class="head">Company No</td>
	    <td class="even" >$this->companyno</td>
        <td class="head">Business Partner Name</td>
          <td class="even" >$this->bpartner_name</td>
      </tr>

      <tr>
        <td class="head">Alternate Name</td>
	    <td class="even" >$this->alternatename</td>
        <td class="head">Employee Count</td>
	    <td class="even" >$this->employeecount</td>
      </tr>

      <tr>
    	<td class="head">Industry</td>
	    <td class="even" >$this->industry_name</td>
  	<td class="head">Active</td>
	    <td class="even" >$checked</td>
      </tr>

     <tr>
    	<td><br></td>
     </tr>

     <tr>
    	<td class="head">Is Debtor (Customer)</td>
	    <td class="even" >$isdebtorchecked</td>
        <td class="head">Is Creditor (Supplier)</td>
	    <td class="even" >$iscreditorchecked</td>
      </tr>
     <tr>
    	<td class="head">Is Transporter</td>
	    <td class="even" >$istransporterchecked</td>
        <td class="head">Is Dealer</td>
	    <td class="even" >$isdealerchecked</td>
      </tr>
     <tr>
    	<td class="head">Is Prospect</td>
	    <td class="even" >$isprospectchecked</td>
           <td class="head">Currency</td>
        <td class="even" >$this->currency_code</td>
      </tr>

       <tr>
    	<td><br></td>
      </tr>


       <tr>
        <td class="head">Tooltips</td>
	    <td class="even">$this->tooltips</td>
        <td class="head">Website</td>
	    <td class="even">$this->bpartner_url</td>
      </tr>

      <tr>
       <td class="head">In Charge Person</td>
	    <td class="even">$this->inchargeperson</td>
       <td class="head">Short Description</td>
            <td class="even">$this->shortremarks</td>
      </tr>

      <tr>
        <td class="head" >Description</td>
	    <td class="even">$this->description</td>

      </tr>

      <tr>
    	<td><br></td>
      </tr>

          <tr><td class="searchformheader" colspan="4">Accounting Parameter:</td></tr>

           <tr>
            <td class="head">Debtor Account</td>
	        <td class="even" id="iddebtoraccountsctrl">$this->debtoraccountsname<input type="hidden" name="previousaccounts_id" value="$this->debtoraccounts_id"></td>
            <td class="head">Creditor Account</td>
	        <td class="even" id="idcreditoraccountsctrl">$this->creditoraccountsname<input type="hidden" name="previousaccounts_id" value="$this->creditoraccounts_id"></td>
           </tr>
           <tr>
            <td class="head">Sales Credit Limit</td>
	        <td class="even">$this->salescreditlimit</td>
            <td class="head">Purchase Credit Limit</td>
	        <td class="even">$this->purchasecreditlimit</td>
           </tr>
           <tr>
            <td class="head">Control Sales Credit Limit</td>
	        <td class="even">$enforcesalescreditlimitchecked</td>
            <td class="head">Control Purchase Credit Limit</td>
	        <td class="even">$enforcepurchasecreditlimitchecked</td>
           </tr>
           <tr>
            <td class="head">Current Sales Limit Status</td>
	        <td class="even">$this->currentsalescreditstatus</td>
            <td class="head">Current Purchase Limit Status</td>
	        <td class="even">$this->currentpurchasecreditstatus</td>
           </tr>
           <tr>
          <td class="head">Terms</td>
	    <td class="even" >$this->terms_name</td>
            <td class="head">Bank Name</td>
	        <td class="even">$this->bankname</td>
           </tr>
           <tr>
            <td class="head">Bank Account Name</td>
	        <td class="even">$this->bankaccountname</td>
            <td class="head">Bank Account No</td>
	        <td class="even">$this->bankaccountno</td>
           </tr>
       </tbody></table></td>
      </tr>

  </table>
</form>
     <table style="text-align:left; width:970px;" align="center" border="0" cellpadding="0" cellspacing="1" >
             <tr><td align="left">$editctrl</td>
              	<td class="head"></td>
       </tr>
     </table>
<script>
window.onload = function(){
// this runs when the iframe has been loaded

    var isactive = "";
    if($this->isactive==1)
            isactive="YES";
    else if($this->isactive==0)
            isactive="NO";

parent.document.getElementById("bpartner_no").innerHTML=": $this->bpartner_no";
parent.document.getElementById("bpartner_name").innerHTML=": $this->bpartner_name";
parent.document.getElementById("bpartnergroup_name").innerHTML=": $this->bpartnergroup_name";
parent.document.getElementById("industry_name").innerHTML=": $this->industry_name";
parent.document.getElementById("industry_name").innerHTML=": $this->industry_name";
parent.document.getElementById("isactive").innerHTML=": "+isactive;
}
</script>
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

<form onsubmit="return validateBPartner()" method="post" action="bpartner.php" name="frmBPartner">

  <table style="width:140px;"><tbody><td><input name="reset" value="Reset" type="reset"></td></tbody></table>

  <table style="text-align: left; width: 100%;" border="1" cellpadding="0" cellspacing="1" >

      <tr >
        <th colspan="4" rowspan="1">$header</th>
      </tr>

      <tr class="searchformblock">
        <td class="head">Organization $mandatorysign</td>
        <td class="even" >$this->orgctrl</td>
   	<td class="head">Business Partner Group $mandatorysign</td>
        <td class="even" >$this->bpartnergroup_name</td>
      </tr>
      <tr>
       <td class="head">Business Partner No $mandatorysign</td>
        <td class="even" >$this->bpartner_no
	&nbsp;Active <input type="checkbox" $checked name="isactive" disabled='disabled'>
        Default Level $mandatorysign =$this->seqno
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
        <td class="head">Currency</td>
        <td class="even" >$this->currency_code</td>
    	<td class="head">Price List</td>
    	<td class="even" >$this->pricelist_name</td>
       <tr>
        <td class="head">Tooltips</td>
	    <td class="even">$this->tooltips</td>
        <td class="head">Website</td>
	    <td class="even">$this->bpartner_url</td>
      </tr>
      <tr>
        <td class="head">Description</td>
	    <td class="even" colspan='3'>$this->description <br/>Short Desc: $this->shortremarks</td>
      </tr>

      <tr>
        <td class="head">Company Representative</td>
        <td class="even" >$this->employee_name</td>
    	<td class="head"></td>
    	<td class="even" >

        </td>
      </tr>


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
   * Save new bpartner into database
   *
   * @return bool
   * @access public
   */
  public function saveBPartner( ) {
    include "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
     //do your sql insert here using $this->employee_name method : return boolean true or false
            global $xoopsDB,$xoopsUser,$defaultorganization_id;

            $timestamp=date("Y-m-d H:i:s",time());
            $createdby=$xoopsUser->getVar('uid');
            $uname=$xoopsUser->getVar('uname');
            $this->updatedby=$xoopsUser->getVar('uid');
            $tablename="sim_bpartner";

     if($this->bpartner_id > 0){//do update sql here

      $this->arrUpdateField=array(
        "bpartnergroup_id","bpartner_no","bpartner_name","isactive","seqno",
        "organization_id","employeecount","alternatename","companyno","industry_id",
          
        "tooltips","bpartner_url","inchargeperson","description","shortremarks",
	"isdebtor","iscreditor","istransporter","isdealer","isprospect","currency_id",

	"creditoraccounts_id","debtoraccounts_id","tax_id",
	"salescreditlimit","purchasecreditlimit",

	"enforcesalescreditlimit","enforcepurchasecreditlimit",
	"currentsalescreditstatus","currentpurchasecreditstatus",

      	"terms_id","bankaccountname","bankname","bankaccountno",
        "created","createdby","updated","updatedby");



    $this->arrUpdateFieldType=array("%d","%s","%s","%d","%d",
                                    "%d","%d","%s","%s","%d",

                                    "%s","%s","%s","%s","%s",
                                    "%d","%d","%d","%d","%d","%d",

                                    "%d","%d","%d",
                                    "%f","%f",

                                    "%d","%d",
                                    "%f","%f",

                                    "%d","%s","%s","%s",
                                    "%s","%d","%s","%d");
   $arrvalue=array(
        $this->bpartnergroup_id,$this->bpartner_no,$this->bpartner_name,$this->isactive,$this->seqno,
        $defaultorganization_id,$this->employeecount,$this->alternatename,$this->companyno,$this->industry_id,

        $this->tooltips,$this->bpartner_url,$this->inchargeperson,$this->description,$this->shortremarks,
	$this->isdebtor,$this->iscreditor,$this->istransporter,	$this->isdealer,$this->isprospect,$this->currency_id,

	$this->creditoraccounts_id,$this->debtoraccounts_id,0,
	$this->salescreditlimit,$this->purchasecreditlimit,

	$this->enforcesalescreditlimit,$this->enforcepurchasecreditlimit,
	$this->currentsalescreditstatus,$this->currentpurchasecreditstatus,

        $this->terms_id,$this->bankaccountname,$this->bankname,$this->bankaccountno,
        $this->created,$this->createdby,$this->updated,$this->updatedby);

    return $save->UpdateRecord($tablename, "bpartner_id", $this->bpartner_id, $this->arrUpdateField, $arrvalue,  $this->arrUpdateFieldType,$this->bpartner_no);

     }else{//do insert sql here

      $this->arrInsertField=array("bpartnergroup_id","bpartner_no","bpartner_name","isactive","seqno",
        "organization_id","employeecount","alternatename","companyno","industry_id",

        "tooltips","bpartner_url","inchargeperson","description","shortremarks",
	"isdebtor","iscreditor","istransporter","isdealer","isprospect","currency_id",

	"creditoraccounts_id","debtoraccounts_id","tax_id",
	"salescreditlimit","purchasecreditlimit",

	"enforcesalescreditlimit","enforcepurchasecreditlimit",
	"currentsalescreditstatus","currentpurchasecreditstatus",

      	"terms_id","bankaccountname","bankname","bankaccountno",
        "created","createdby","updated","updatedby");



      $this->arrInsertFieldType=array("%d","%s","%s","%d","%d",
                                    "%d","%d","%s","%s","%d",

                                    "%s","%s","%s","%s","%s",
                                    "%d","%d","%d","%d","%d","%d",

                                    "%d","%d","%d",
                                    "%f","%f",

                                    "%d","%d",
                                    "%f","%f",

                                    "%d","%s","%s","%s",
                                    "%s","%d","%s","%d");




 $arrvalue=array($this->bpartnergroup_id,$this->bpartner_no,$this->bpartner_name,$this->isactive,$this->seqno,
        $defaultorganization_id,$this->employeecount,$this->alternatename,$this->companyno,$this->industry_id,

        $this->tooltips,$this->bpartner_url,$this->inchargeperson,$this->description,$this->shortremarks,
	$this->isdebtor,$this->iscreditor,$this->istransporter,	$this->isdealer,$this->isprospect,$this->currency_id,

	$this->creditoraccounts_id,$this->debtoraccounts_id,0,
	$this->salescreditlimit,$this->purchasecreditlimit,

	$this->enforcesalescreditlimit,$this->enforcepurchasecreditlimit,
	$this->currentsalescreditstatus,$this->currentpurchasecreditstatus,

        $this->terms_id,$this->bankaccountname,$this->bankname,$this->bankaccountno,
        $timestamp,$this->updatedby,$timestamp,$this->updatedby);

  return $save->InsertRecord($tablename, $this->arrInsertField, $arrvalue, $this->arrInsertFieldType, $this->bpartner_name,"bpartner_id");

     }

  } // end of member function insertBPartner

  /**
   * Pull data from bpartner table into class
   *
   * @return bool
   * @access public
   */
  public function fetchBpartnerData($bpartner_id) {
        global $issimbiz;
	$this->log->showLog(3,"Fetching bpartner detail into class BPartner.php.<br>");

        if($issimbiz==true)
            {
            $acc="ac1.accounts_name as debtoraccountsname,ac2.accounts_name as creditoraccountsname, ";
            $accsql="LEFT JOIN sim_simbiz_accounts ac1 on ac1.accounts_id=bp.debtoraccounts_id
                     LEFT JOIN sim_simbiz_accounts ac2 on ac2.accounts_id=bp.creditoraccounts_id";
            }

	 $sql="SELECT
         bp.bpartner_id,bp.bpartnergroup_id,bp.bpartner_no,bp.bpartner_name,bp.isactive,bp.seqno,
	 bp.organization_id,bp.employeecount,bp.alternatename,bp.companyno,bp.industry_id,

         bp.tooltips,bp.bpartner_url,bp.inchargeperson,bp.description,bp.shortremarks,
	 bp.isdebtor,bp.iscreditor,bp.istransporter,bp.isdealer,bp.isprospect,bp.currency_id,

         bp.debtoraccounts_id,bp.creditoraccounts_id,bp.tax_id,
         bp.salescreditlimit,bp.purchasecreditlimit,
       
	 bp.enforcesalescreditlimit,bp.enforcepurchasecreditlimit,
	 bp.currentsalescreditstatus,bp.currentpurchasecreditstatus,

	 bp.currentbalance,

         bp.terms_id,bp.bankaccountname,bp.bankname,bp.bankaccountno,
         bp.created,bp.createdby,bp.updated,bp.updatedby,

        cr.currency_code,
        cr.currency_name,
          $acc
        tm.terms_name,
        i.industry_name,
        bpg.bpartnergroup_name
	from $this->tablebpartner bp
        $accsql
	INNER JOIN $this->tablecurrency cr on bp.currency_id=cr.currency_id
	LEFT JOIN $this->tableterms tm on tm.terms_id=bp.terms_id
	INNER JOIN $this->tablebpartnergroup bpg on bpg.bpartnergroup_id=bp.bpartnergroup_id
        LEFT JOIN $this->tableindustry i on i.industry_id=bp.industry_id
	where bp.bpartner_id=$bpartner_id";

	$this->log->showLog(4,"ProductBPartner->fetchBPartner, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$this->bpartner_id=$row['bpartner_id'];
	$this->bpartnergroup_id=$row['bpartnergroup_id'];
	$this->bpartner_no=$row['bpartner_no'];
	$this->bpartner_name=$row['bpartner_name'];
        $this->inchargeperson=$row['inchargeperson'];
	$this->isactive=$row['isactive'];
	$this->seqno=$row['seqno'];
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
	$this->shortremarks=$row['shortremarks'];
	$this->currentbalance=$row['currentbalance'];
	$this->creditoraccounts_id=$row['creditoraccounts_id'];
        	$this->creditoraccountsname=$row['creditoraccountsname'];
                $this->debtoraccountsname=$row['debtoraccountsname'];
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
    $this->employee_id=$row['employee_id'];
    $this->employee_name=$row['employee_name'];
    $this->employee_no=$row['employee_no'];
    $this->pricelist_id=$row['pricelist_id'];
    $this->pricelist_name=$row['pricelist_name'];
   	$this->log->showLog(4,"BPartner->fetchBPartner,database fetch into class successfully");
	$this->log->showLog(4,"bpartner_name:$this->bpartner_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
      //  exit(0);
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
        //global $isadmin;
        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();

    	$this->log->showLog(2,"Warning: Performing delete bpartner id : $bpartner_id !");

        $this->fetchBpartnerData($bpartner_id);
        $controlvalue=$this->bpartner_no;
        $isdeleted=$this->isdeleted;

//      if($isadmin==1)
        return $save->DeleteRecord("sim_bpartner","bpartner_id",$bpartner_id,$controlvalue,1);
//      else
//        return false;

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
		bp.organization_id,bp.seqno,bp.bpartnergroup_id,
		tm.terms_name,bp.salescreditlimit,bp.tooltips,shortremarks
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
		<th style="text-align:center;">Short Remarks</th>
		<th style="text-align:center;">Credit Limit
		<image id="ids_creditlimit" src="images/sortdown.gif" onclick="sortList(this.id)">
		<input type="hidden" name="ids_creditlimit">
		</th>
		<th style="text-align:center;"></th>
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
		$seqno=$row['seqno'];
		$bpartnergroup_id=$row['bpartnergroup_id'];
		$terms_name=$row['terms_name'];
		$isactive=$row['isactive'];
		$shortremarks=$row['shortremarks'];
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
			<td class="$rowtype" style="text-align:center;">$shortremarks</td>
			<td class="$rowtype" style="text-align:center;">$salescreditlimit</td>
			<td class="$rowtype" style="text-align:center;">
				<form action="bpartner.php" method="POST">
				<input type="image" src="images/edit.gif" name="submit" title="Edit this Record">
				<input type="hidden" value="$bpartner_id" name="bpartner_id">
				<input type="hidden" name="action" value="edit">
				</form>
			</td>
			<td class="$rowtype" style="text-align:center;"><input name="checkbox$i" type="checkbox"></td>

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
		$seqno=$row['seqno'];
		$bpartnergroup_id=$row['bpartnergroup_id'];
		$terms_name=$row['terms_name'];
		$isactive=$row['isactive'];
		$tooltips=$row['tooltips'];
		$shortremarks=$row['shortremarks'];

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
        global  $xoopsUser;
        $this->updatedby=$xoopsUser->getVar('uid');

      	$sql=sprintf("SELECT MAX(bpartner_id) as bpartner_id from sim_bpartner WHERE createdby = '%d'",$this->updatedby);
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

	$sql="SELECT MAX(seqno) + 10 as seqno from $this->tablebpartner;";
	$this->log->showLog(3,'Checking next seqno');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next seqno:' . $row['seqno']);
		return  $row['seqno'];
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

//  public function searchAToZ(){
//	global $defaultorganization_id;
//	$this->log->showLog(3,"Prepare to provide a shortcut for user to search student easily. With function searchAToZ()");
//	$sqlfilter=	"SELECT DISTINCT(LEFT(bpartner_name,1)) as shortname FROM $this->tablebpartner
//			where isactive=1 and bpartner_id>0
//			and organization_id = $defaultorganization_id
//			order by bpartner_name";
//	$query=$this->xoopsDB->query($sqlfilter);
//	$i=0;
//echo "<b>Business Partner Grouping By Name: </b><br>";
//	while ($row=$this->xoopsDB->fetchArray($query)){
//		$i++;
//		$shortname=$row['shortname'];
//		if($i==1 && $filterstring=="")
//			$filterstring=$shortname;//if customer never do filter yet, if will choose 1st customer listing
//
//		echo "<A href='bpartner.php?filterstring=$shortname'> $shortname </A> ";
//	}
//
//		echo "<A href='bpartner.php?filterstring=all'> -<u>Show All</u>- </A> ";
//		echo <<<EOF
//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
//
//
//EOF;
//return $filterstring;
//
//	$this->log->showLog(3,"Complete generate list of short cut");
//  }

  public function searchAToZ(){
	global $mode,$defaultorganization_id;

	$this->log->showLog(3,"Prepare to provide a shortcut for user to search product easily. With function searchAToZ()");
        $wherestring = "where bpartner_id >0 AND organization_id=$defaultorganization_id";

	$sqlfilter="SELECT DISTINCT(LEFT(bpartner_name,1)) as shortname FROM sim_bpartner $wherestring order by bpartner_name";

	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";
       
	$searchatoz= "<b>Business Partner Grouping By Name: </b><br>";
	while ($row=$this->xoopsDB->fetchArray($query)){

		$i++;
		$shortname=strtoupper($row['shortname']);
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if secretarial never do filter yet, if will choose 1st secretarial listing

		$searchatoz.= "<A style='font-size:12;' href='javascript:searchchar(\"$shortname\")'>  $shortname  </A> ";
	}
         $searchatoz.= "<A style='font-size:12;' href='javascript:searchall()'> [SHOW ALL] </A> ";

//
//	$this->log->showLog(3,"Complete generate list of short cut");
//echo <<< EOF
//	<BR>
//EOF;
return $searchatoz;

  	}
        
  public function searchAToZforDetail(){
	global $mode,$defaultorganization_id;

	$this->log->showLog(3,"Prepare to provide a shortcut for user to search product easily. With function searchAToZ()");
        $wherestring = "where bpartner_id >0 AND organization_id=$defaultorganization_id";

	$sqlfilter="SELECT DISTINCT(LEFT(bpartner_name,1)) as shortname FROM sim_bpartner $wherestring order by bpartner_name";

	$this->log->showLog(4,"With SQL:$sqlfilter");
	$query=$this->xoopsDB->query($sqlfilter);
	$i=0;
	$firstname="";

	$searchAToZ = "<br><b>Filter Employee Grouping By Name: </b>";
	while ($row=$this->xoopsDB->fetchArray($query)){

		$i++;
		$shortname=strtoupper($row['shortname']);
		if($i==1 && $filterstring=="")
			$filterstring=$shortname;//if secretarial never do filter yet, if will choose 1st secretarial listing

		$searchAToZ .= "<A style='font-size:12;' href='bpartner.php?action=search&filterstring=$shortname'>  $shortname  </A> ";
	}
       $searchAToZ .=  "<A style='font-size:12;' href='bpartner.php?action=search'> [SHOW All] </A> ";

//
//	$this->log->showLog(3,"Complete generate list of short cut");
//echo <<< EOF
//	<BR>
//EOF;
return $searchAToZ;

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


  public function getBpartnerSearchForm(){//use nitobi

   $new_button = $this->getFormButton("Add New","bpartner.php");
   if($this->filterstring!="")
     $bpartnerchar="Business Partner Name : $this->filterstring";

   $search=$this->searchAToZ();
   $colstyle="style=width:135px";
   $inputstyle="width=112px";
  if($isadmin==1)
  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\">".
        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";

  echo <<< EOF

<table style="width:990px;" align="center">

 <tr><td>$search</td></tr>
  
 <tr>
  <td align="center" >
<div align="left">$new_button</div>
<div id='centercontainer' >

<form name="frmEmployeeSearch" id="frmEmployeeSearch" onsubmit="search();return false;">
<table>
 <tr><td></td></tr>
   <tr> <td colspan="7" class="searchformheader">Search Business Partner</td> </tr>

   <tr>
    <td class="searchformblock">

   <table >
    <tr>
      <td class="head">Business Partner No</td>
      <td class="even"><input type="text" $colstyle name="searchbpartner_no" id="searchbpartner_no" value="$this->searchbpartner_no"/></td>
      <td class="head">Business Partner Name</td>
      <td class="even"><input type="text" $colstyle name="searchbpartner_name" id="searchbpartner_name" value="$this->searchbpartner_name"/></td>
   </tr>

   <tr>
      <td class="head">Business Partner Group</td>
      <td class="even">
         <select name="searchbpartnergroup_id" id="searchbpartnergroup_id" $colstyle>
           $this->bpartnergroupctrl
         </select>
      </td>
      <td class="head">Industry</td>
      <td class="even">
         <select name="searchindustry_id" id="searchindustry_id" $colstyle>
           $this->industryctrl
         </select>
      </td>

   </tr>

   <tr>
      <td class="head">In Charge Person</td>
      <td class="even"><input type="text" $colstyle name="searchpic" id="searchpic" value="$this->searchpic"/></td>
      <td class="head">Is Active</td>
      <td class="even">
           <select $colstyle name="searchisactive" id="searchisactive">
             <option value="0" >Null</option>
             <option value="Y" >Yes</option>
             <option value="N" >No</option>
          </select>
      </td>
   </tr>

   <tr>
      <td $style colspan="2">
      <input type="hidden" name="issearch" id="issearch" value="Y"/>
      <input type="hidden" name="action" value="search"/>
      <input type="submit" value="Search"/>
      <input type="button" value="Reset" onclick="reset();"/></td>
   </tr>

 </table>
 </td>

 <td class="searchformblock2">

   <table ><tr style="vertical-align: top;">
       <td rowspan="4" style="width:240px;" class="even">
           <div id="totalRecord"></div>
           <div id="rightBox">$bpartnerchar</div>
      </td>
    </tr>
    </table>

  </td>
  </tr>
</table>
</form>
    </div>

</td></tr></table>



EOF;

 }

  public function getShowResultForm(){//use nitobi
global $nitobigridthemes,$isadmin,$havewriteperm;
$rowsperpage = 20;

if($this->filterstring!="")
        $filterstring="&searchchar=$this->filterstring";

if($isadmin==1){
    $grIdColumn=9; //define primary key column index, it will set as readonly afterwards (count from 0)
       // $deleteddefaultvalue_js="myGrid.getCellObject(rowNo,6).setValue(0);"; //if admin login got deleted column, during admin insert new record shall set it default =0 (not deleted)
}
else{
    $grIdColumn=9;//define primary key column index for normal user
    $deleteddefaultvalue_js="";
}

if($havewriteperm==1){ //user with write permission can edit grid, have button

   $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";

   $savectrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
     <input name="btnSave" onclick="save()" value="Save" type="button">
     <input name="btnDelete" onclick="onclickdeletebutton()" value="Delete" type="button">';
    $alloweditgrid= "col!=$grIdColumn";
}
else{ //user dun have write permission, cannot save grid
    $savectrl="";
   $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $alloweditgrid= "false";
}
 echo <<< EOF

  <script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){
    nitobi.loadComponent('DataboundGrid');

    }));

    function init(){}
     function reset(){}

   function searchchar(char)
   {

        var grid = nitobi.getGrid("DataboundGrid");
  	grid.getDataSource().setGetHandlerParameter('issearch',"Y");
	grid.getDataSource().setGetHandlerParameter('searchchar',char);
        //reload grid data
	grid.dataBind();
    Pager.First('DataboundGrid');
    }

   function searchall(){
        document.frmEmployeeSearch.reset();
        search();
    }
     function search(){

        var grid = nitobi.getGrid("DataboundGrid");

        var issearch=document.getElementById("issearch").value;

        var searchbpartner_no=document.getElementById("searchbpartner_no").value;
        var searchbpartner_name=document.getElementById("searchbpartner_name").value;
        var searchbpartnergroup_id=document.getElementById("searchbpartnergroup_id").value;
        var searchindustry_id=document.getElementById("searchindustry_id").value;
        var searchpic=document.getElementById("searchpic").value;

          var industry_id = document.frmEmployeeSearch.searchindustry_id.selectedIndex;
          var searchindustry_name = document.frmEmployeeSearch.searchindustry_id[industry_id].text;

          var bpartnergroup_id = document.frmEmployeeSearch.searchbpartnergroup_id.selectedIndex;
          var searchbpartnergroup_name = document.frmEmployeeSearch.searchbpartnergroup_id[bpartnergroup_id].text;

          var searchisactive=document.getElementById("searchisactive").value;

          var searchTxt = "";

        if(searchbpartner_no != "")
        searchTxt += "Business Partner No : "+searchbpartner_no+"<br/>";
        if(searchbpartner_name != "")
        searchTxt += "Business Partner Name : "+searchbpartner_name+"<br/>";

        if(searchbpartnergroup_id != "0")
        searchTxt += "Business Partner Group: "+searchbpartnergroup_name+"<br/>";
        if(searchindustry_id != "0")
        searchTxt += "Industry : "+searchindustry_name+"<br/>";

        if(searchpic != "")
        searchTxt += "In Charge Person : "+searchpic+"<br/>";

        if(searchisactive == "Y")
        searchTxt += "Active : Yes<br/>";
        else if(searchisactive=="N")
        searchTxt += "Active : No<br/>";

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */

        //Submit javascript to grid with _GET method

	grid.getDataSource().setGetHandlerParameter('issearch',issearch);
	grid.getDataSource().setGetHandlerParameter('searchisactive',searchisactive);
	grid.getDataSource().setGetHandlerParameter('searchbpartner_no',searchbpartner_no);
	grid.getDataSource().setGetHandlerParameter('searchbpartner_name',searchbpartner_name);
	grid.getDataSource().setGetHandlerParameter('searchbpartnergroup_id',searchbpartnergroup_id);
        grid.getDataSource().setGetHandlerParameter('searchindustry_id',searchindustry_id);
        grid.getDataSource().setGetHandlerParameter('searchpic',searchpic);

	grid.getDataSource().setGetHandlerParameter('searchchar',"");
        document.getElementById('rightBox').innerHTML = searchTxt;
        //reload grid data

	grid.dataBind();
    Pager.First('DataboundGrid');
    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        //      var myAjaxRequest = new nitobi.ajax.HttpRequest();
        //      myAjaxRequest.handler = 'getMaxID.php?idname=jobposition_id&tablename=sim_hr_jobposition';
        //      myAjaxRequest.async = false;
        //      myAjaxRequest.get();
        //      myResultKey = myAjaxRequest.httpObj.responseText;
        //      myResultKey.replace(/s/g, '');
        //      myResultKey = parseInt(myResultKey) + 1;
        //      return myResultKey.toString();
        return 0;
    }

    //after grid html render properly, set focus on it. It is important when use choose particular cell but
    // immediately press search again. From screen we won't detect cell is selected infact from javascript
    // detect selected
   function dataready(){

       var  g = nitobi.getGrid('DataboundGrid');
        g.move(0,0);//need to trigger relative position 0,0 in for next code able to highlight at screen
        var selRow = g.getSelectedRow();

    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();

        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Record saved successfully</a>";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                         search();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	search();

                popup('popUpDiv');

        	return false;
        	}
    }

    //if save_data have error, trigger this function
    function showError(){

        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();



        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">"+errorMessage+"</a><br/>";
            // document.getElementById('popupmessage').innerHTML="Please Wait.....";
            // grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
          // document.getElementById('popupmessage').innerHTML="Please Wait.....";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
//                    row=eventArgs.getCell().getRow();
//                    col=eventArgs.getCell().getColumn();
//                    var  myGrid = nitobi.getGrid('DataboundGrid');
//                    var myCell = myGrid.getCellObject(row, col);
//                    myCell.edit();
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

    function checkAllowEdit(eventArgs){
//	var g= nitobi.getGrid('DataboundGrid');
//        col=eventArgs.getCell().getColumn();
//        if(col==0) //if user have permission to edit the cell, control primary key column read only at here too
//        return true;
//        else
//        return false;
        }

     function doubleclickrecord(eventArgs){

   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var bpartner_id = g.getCellValue(selRow, 8);
         var newWindow = window.open('bpartner.php?action=viewsummary&bpartner_id='+bpartner_id, '_blank');
          newWindow.focus();

        }

//after insert a new line will automatically fill in some value here
  function setDefaultValue(eventArgs)
   {
   var myGrid = eventArgs.getSource();
   var r = eventArgs.getRow();
   var rowNo = r.Row;
   myGrid.getCellObject(rowNo,3).setValue(10);
        $deleteddefaultvalue_js
   myGrid.selectCellByCoords(rowNo, 0);
}

	function beforeDelete(){
		if(confirm('Delete this record? Data will save into database immediately.')){
			document.getElementById("afterconfirm").value=1;
      //popup('popUpDiv');
			return true;
		}
			else{
			document.getElementById("afterconfirm").value=0;
			return false;
			}
		}

function selectAll(val){

     var grid= nitobi.getGrid('DataboundGrid');
     var dataSource =grid.getDataSource();

     total_row = $rowsperpage;
     //total_row = document.getElementById('totalrowpages').value;

    //alert(total_row);

    for( var i = 0; i < total_row; i++ ) {
    //var xi = selectedRows[i].getAttribute("xi");
    var celly = grid.getCellObject( i, 0);//1st para : row , 2nd para : column seq

    if(val == true)
    celly.setValue( "1" );
    else
    celly.setValue( "0" );

    }

}

 function generateLetter(){

    var grid= nitobi.getGrid('DataboundGrid');
    var dataSource =grid.getDataSource();
    var employee_no = '';

    total_row = $rowsperpage;
    istrue = false;

    for( var i = 0; i < total_row; i++ ) {

    var celly = grid.getCellObject( i, 0);//1st para : row , 2nd para : column seq

    if(celly.getValue() == 1){
    istrue = true;
    employee_no = employee_no+','+grid.getCellObject( i, 1).getValue();
    }


    }

    if(istrue == false){
    alert("Please Select Employee");
    }else{
    document.getElementById('employeeselected').value = employee_no;

    document.forms['frmEmployeeListTable'].submit();
    }

}

  function checkedBpartner(){

    var grid= nitobi.getGrid('DataboundGrid');
    var dataSource =grid.getDataSource();
    var bpartner_no = '';

    total_row = $rowsperpage;
    istrue = false;

    for( var i = 0; i < total_row; i++ ) {

    var celly = grid.getCellObject( i, 0);//1st para : row , 2nd para : column seq

    if(celly.getValue() == 1){
    istrue = true;
    bpartner_no = bpartner_no+','+grid.getCellObject( i, 1).getValue();

    }

   }
    if(istrue == false){
    alert("Please Select Business Partner");
    return false;
    }else{
    document.getElementById('bpartnerselected').value = bpartner_no;

    return true;
    }
  }
     function validate(){
         if(checkedBpartner()){ 
            var action=document.frmBpartnerListTable.action.value;
            var confirmtext="";
            if(action=='sendsms')
                confirmtext=prompt("Confirm send SMS? It will charge RM0.15 per message","No");
            else if(action=='sendemail')
                confirmtext=prompt("Confirm send out this email?","No");

             if(confirmtext=='Yes')
                return true;
             else
                return false;
         }
         else
           return false;

     }

      function edit(){
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();

        var bpartner_id = g.getCellValue(selRow, 8);

      window.open("bpartner.php?action=tablist&mode=edit&bpartner_id="+bpartner_id,"");
    }
</script>
<br/>

<div align="center">

     <form name="frmBpartnerListTable" action="bpartner.php" method="POST" target="_blank" onsubmit='return validate()'>
     <input type="hidden"  name="bpartnerselected" id="bpartnerselected" value="">
     <input type="hidden"  name="action" id="action" value="">
     <input type="hidden" id="totalRowGrid" value="$rowsperpage">
<table style="width:700px;" class="searchformblock" >

 <tr >
    <td class="head tdPager" colspan="2" >

    <div id="pager_control" class="inline">
    <div id="pager_first" class="inline FirstPage" onclick="Pager.First('DataboundGrid');" onmouseover="this.className+=' FirstPageHover';" onmouseout="this.className='inline FirstPage';" style="margin:0;border-right:1px solid #B1BAC2;"></div>
    <div id="pager_prev" class="inline PreviousPage" onclick="Pager.Previous('DataboundGrid');" onmouseover="this.className+=' PreviousPageHover';" onmouseout="this.className='inline PreviousPage';" style="margin:0;"></div>
    <div class="inline" style="height:22px;top:3px;">
        <span class="inline">Page</span>
        <span class="inline" id="pager_current">0</span>
        <span class="inline">of</span>
        <span class="inline" id="pager_total">0</span>
    </div>
    <div id="pager_next" class="inline NextPage" onclick="Pager.Next('DataboundGrid');" onmouseover="this.className+=' NextPageHover';" onmouseout="this.className='inline NextPage';" style="margin:0;border-right:1px solid #B1BAC2;"></div>
    <div id="pager_last" class="inline LastPage" onclick="Pager.Last('DataboundGrid');" onmouseover="this.className+=' LastPageHover';" onmouseout="this.className='inline LastPage';" style="margin:0;"></div>
    </div>
    </td>
 </tr>

<tr ><td align="center" colspan="2">
<div>
<ntb:grid id="DataboundGrid"
     mode="standard"
     editable="false"
     toolbarenabled='false'
     $permctrl
     ondatareadyevent="HandleReady(eventArgs);"
     oncelldblclickevent="doubleclickrecord(eventArgs)"
     oncellclickevent="clickrecord(eventArgs)"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="bpartner.php?action=searchbpartner&isactive=1$filterstring"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     onafterrowinsertevent="setDefaultValue(eventArgs)"
     rowhighlightenabled="true"
     width="970"
     height="245"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes"
     rowsperpage="$rowsperpage">


 <ntb:columns>

   <ntb:textcolumn classname="{\$rh}" width="80" label="B.Partner No" xdatafld="bpartner_no"      editable="false"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" width="220" label="Business Partner Name" xdatafld="bpartner_name"      editable="false"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" width="140" label="Business Partner Group" xdatafld="bpartnergroup_name"      editable="false"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" width="140" label="In Charge Person" xdatafld="inchargeperson"      editable="false"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" width="80" label="Terms" xdatafld="terms_name"      editable="false"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" width="180" label="Short Remarks" xdatafld="shortremarks"      editable="false"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" width="40" label="Active"  xdatafld="isactive"      editable="false"></ntb:textcolumn>

<ntb:textcolumn classname="{\$rh}" label="Edit"   xdatafld=""    width="25"  sortenabled="false"      editable="false" classname="{\$rh}" oncellclickevent="javascript:edit()">
            <ntb:imageeditor imageurl="images/edit.gif"></ntb:imageeditor> </ntb:textcolumn>

      <ntb:numbercolumn   label="ID"  width="0" xdatafld="bpartner_id" mask="###0" sortenabled="false">
                    </ntb:numbercolumn>
 </ntb:columns>
 </ntb:grid>
    </div>
</td></tr>

    <tr colspan="2">
    <td><div id="msgbox" style='display:none'></div></td>
    </tr>
</table>
    </form></div>
EOF;



 }

  public function showSearchResult($wherestring){

    include_once "../simantz/class/EBAGetHandler.php";
    $getHandler = new EBAGetHandler();
    $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);

    global $xoopsDB,$wherestring,$xoopsUser,$isadmin,$defaultorganization_id;

            $pageSize=10;
        if (isset($_GET['PageSize'])) {
                $pageSize = $_GET['PageSize'];
                if(empty($pageSize)){
                        $pageSize=10;
                }
        }
        $ordinalStart=0;
        if (isset($_GET['StartRecord'])) {
                $ordinalStart = $_GET['StartRecord'];
                if(empty($ordinalStart)){
                        $ordinalStart=0;
                }
        }
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];

    $tablename="sim_bpartner";
    $tablebpartnergroup="sim_bpartnergroup";
    $tableindustry="sim_industry";

    $issearch=$_GET['issearch'];
    $searchbpartner_no=$_GET['searchbpartner_no'];
    $searchbpartner_name=$_GET['searchbpartner_name'];
    $searchbpartnergroup_id=$_GET['searchbpartnergroup_id'];
    $searchindustry_id=$_GET['searchindustry_id'];
    $searchpic=$_GET['searchpic'];

    $searchisactive=$_GET['searchisactive'];
    $searchchar=$_GET['searchchar'];

    $this->log->showLog(2,"Access ShowBPartner($wherestring)");

        if(empty($sortcolumn)){
           $sortcolumn="bp.seqno, bp.bpartner_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

//      if($searchchar !=""){
//           $wherestring.= " AND a.employee_name LIKE '".$searchchar."%'";
//      }

if($searchchar !="")
    $wherestring.= " AND bp.bpartner_name LIKE '".$searchchar."%'";
else
    {
     if($searchbpartner_no !="")
           $wherestring.= " AND bp.bpartner_no LIKE '%".$searchbpartner_no."%'";
     if($searchbpartner_name !="")
           $wherestring.= " AND bp.bpartner_name LIKE '%".$searchbpartner_name."%'";
     if($searchpic !="")
           $wherestring.= " AND bp.inchargeperson LIKE '%".$searchpic."%'";
     if($searchbpartnergroup_id !="" && $searchbpartnergroup_id !="0")
           $wherestring.= " AND bp.bpartnergroup_id=$searchbpartnergroup_id";
     if($searchindustry_id !="" && $searchindustry_id !="0" )
           $wherestring.= " AND bp.industry_id=$searchindustry_id";
     if($searchisactive =="Y")
           $wherestring.= " AND bp.isactive =1";
     else if($searchisactive =="N")
           $wherestring.= " AND bp.isactive=0";
    }
           $wherestring.= " AND bp.organization_id=$defaultorganization_id";
           
      $sql = "SELECT bp.*, bpg.bpartnergroup_name, terms_name
              FROM $tablename bp
              inner join sim_bpartnergroup bpg on bpg.bpartnergroup_id = bp.bpartnergroup_id
              left join sim_terms te on te.terms_id = bp.terms_id
                  
             $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";

        $rcode = $_GET['rcode'];
        $_SESSION['sql_txt_'.$rcode] = $sql;

      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);


        $getHandler->ProcessRecords();
     	$getHandler->DefineField("bpartner_no");
     	$getHandler->DefineField("bpartner_name");
        $getHandler->DefineField("bpartnergroup_name");
     	$getHandler->DefineField("terms_name");
        $getHandler->DefineField("shortremarks");
        $getHandler->DefineField("isactive");
        $getHandler->DefineField("edit");
        $getHandler->DefineField("inchargeperson");
        $getHandler->DefineField("bpartner_id");
        $getHandler->DefineField("rh");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
                    $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {
          if($rh=="even")
            $rh="odd";
          else
            $rh="even";
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['bpartner_id']);
             $getHandler->DefineRecordFieldValue("bpartner_no",$row['bpartner_no']);
             $getHandler->DefineRecordFieldValue("bpartner_name", $row['bpartner_name']);
             $getHandler->DefineRecordFieldValue("bpartnergroup_name", $row['bpartnergroup_name']);
             $getHandler->DefineRecordFieldValue("terms_name",$row['terms_name']);
             $getHandler->DefineRecordFieldValue("shortremarks",$row['shortremarks']);
             $getHandler->DefineRecordFieldValue("inchargeperson",$row['inchargeperson']);
             $getHandler->DefineRecordFieldValue("isactive",($row['isactive'] == 1 ? "Yes" : "No"));
             $getHandler->DefineRecordFieldValue("edit","bpartner.php?action=tablist&mode=edit&bpartner_id=".$row['bpartner_id']);
             $getHandler->DefineRecordFieldValue("bpartner_id",$row['bpartner_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->setErrorMessage($currentRecord);
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showBpartner()");
    }

  public function getEmail(){
        $this->bpartnerselected = substr($this->bpartnerselected,1);

//echo $this->bpartnerselected; die;
        $array_bpartner = explode(',',$this->bpartnerselected);

        $i=0;
        $j=0;
        $result="";
        $this->log->showLog(3,"call GetEmail");
        foreach($array_bpartner as $bpartner_no){
        $i++;

            //if($this->isselected[$i] == "on"){
            $j++;
             $sql = "select emp.employee_name,emp.employee_no,u.email
                        from sim_hr_employee emp, sim_users u
                        where emp.uid = u.uid AND emp.employee_no = '$employee_no' ";

            $query=$this->xoopsDB->query($sql);

            if ($row=$this->xoopsDB->fetchArray($query)){
            $employee_name = $row['employee_name'];
            $employee_no = $row['employee_no'];
             $email = $row['email'];
                if($email!="")
                    $result.=$email.",";
            }
        //}
        }
     $result=substr_replace($result,"",-1);
        return $result;
    }

  public function showSummary(){
 global $havewriteperm;
$this->fetchBpartnerData($this->bpartner_id);

   $style="style='height:25px; vertical-align:middle;'";
if($havewriteperm==1){ //user with write permission can edit grid, have button
  $edit_button = $this->getFormButton("Edit","bpartner.php",array("action"=>"tablist","mode"=>"edit","bpartner_id"=>"$this->bpartner_id") );
}

else{ //user dun have write permission, cannot save grid
   $edit_button="";
}
   $view_button = $this->getFormButton("View Details","bpartner.php",array("action"=>"tablist","mode"=>"view","bpartner_id"=>"$this->bpartner_id") );

                if ($this->isactive==1)
			$checked="Yes";
		else
			$checked="No";

		if ($this->isdebtor==1)
			$isdebtorchecked="Yes";
		else
			$isdebtorchecked="No";

		if ($this->iscreditor==1)
			$iscreditorchecked="Yes";
		else
			$iscreditorchecked="No";

		if ($this->istransporter==1)
			$istransporterchecked="Yes";
		else
			$istransporterchecked="No";

		if ($this->isdealer==1)
			$isdealerchecked="Yes";
		else
			$isdealerchecked="No";

		if ($this->isprospect==1)
			$isprospectchecked="Yes";
		else
			$isprospectchecked="No";

		if ($this->enforcesalescreditlimit==1)
			$enforcesalescreditlimitchecked="Yes";
		else
			$enforcesalescreditlimitchecked="No";

		if ($this->enforcepurchasecreditlimit==1)
			$enforcepurchasecreditlimitchecked="Yes";
		else
			$enforcepurchasecreditlimitchecked="No";

                if(left($this->bpartner_url,4)=="http")
                        $this->bpartner_url="<a href='$this->bpartner_url' target='_blank'>$this->bpartner_url</a>";
  echo <<< EOF

 <table><tr >

<td width="50%" colspan="3">

 <table  class="emplpoyeesummaryblock">
   <tr 
    <td class="searchformheader" colspan="4">Basic Info</td>
   </tr>

   <tr > 	
    <td class="head">Business Partner No</td>
      <td class="even">$this->bpartner_no</td>
    <td class="head">Active</td>
      <td class="even">$checked</td>
   </tr>

   <tr>
    <td class="head">Company No</td>
      <td class="even">$this->companyno</td>
    <td class="head">Business Partner Name</td>
      <td class="even">$this->bpartner_name</td>
   </tr>

   <tr>
    <td class="head">Alternate Name</td>
      <td class="even">$this->alternatename</td>
    <td class="head">Employee Count</td>
      <td class="even">$this->employeecount</td>
   </tr>

   <tr>
    <td class="head">Industry</td>
      <td class="even">$this->industry_name</td>
    <td class="head">Business Partner Group</td>
      <td class="even">$this->bpartnergroup_name</td>
   </tr>

   <tr>
    <td class="head">Is Debtor (Customer)</td>
      <td class="even">$isdebtorchecked</td>
    <td class="head">Is Creditor (Supplier)</td>
      <td class="even">$iscreditorchecked</td>
   </tr>

   <tr>
    <td class="head">Is Transporter</td>
      <td class="even">$istransporterchecked</td>
    <td class="head">Is Dealer</td>
      <td class="even">$isdealerchecked</td>
   </tr>

   <tr>
    <td class="head">Is Prospect</td>
      <td class="even">$isprospectchecked</td>
    <td class="head">Currency</td>
      <td class="even">$this->currency_code</td>
   </tr>

   <tr>
    <td class="head">Tooltips</td>
      <td class="even">$this->tooltips</td>
    <td class="head">Website</td>
      <td class="even">$this->bpartner_url</td>
   </tr>

   <tr>
    <td class="head">In Charge Person</td>
    <td class="even">$this->employee_name</td>
    <td class="head">Short Description</td>
    <td class="even"><b>$this->shortremarks</b></td>
   </tr>

   <tr>
    <td class="head">Description</td>
    <td class="even" colspan="3"><b>$this->description</b></td>
   </tr>

   <tr>
    <td colspan="4"><br></td>
   </tr>

   <tr>
    <td class="searchformheader" colspan="4">Account Info</td>
   </tr>

   <tr>
    <td class="head">Debtor Account</td>
    <td class="even">$this->debtoraccountsname</td>
    <td class="head">Creditor Account</td>
    <td class="even">$this->creditoraccountsname</td>
   </tr>

   <tr>
    <td class="head">Sales Credit Limit</td>
    <td class="even">$this->salescreditlimit</td>
    <td class="head">Purchase Credit Limit</td>
    <td class="even">$this->purchasecreditlimit</td>
   </tr>

   <tr>
    <td class="head">Control Sales Limit</td>
    <td class="even">$enforcesalescreditlimitchecked</td>
    <td class="head">Control Purchase Limit</td>
    <td class="even">$enforcepurchasecreditlimitchecked</td>
   </tr>

   <tr>
    <td class="head">Current Sales Limit Status</td>
    <td class="even">$this->currentsalescreditstatus</td>
    <td class="head">Current Purchase Limit Status</td>
    <td class="even">$this->currentpurchasecreditstatus</td>
   </tr>
          
   <tr>
    <td class="head">Terms</td>
    <td class="even">$this->terms_name</td>
    <td class="head">Bank Name</td>
    <td class="even">$this->bankname</td>
   </tr>

   <tr>
    <td class="head">Bank Account Name</td>
    <td class="even">$this->bankaccountname</td>
    <td class="head">Bank Account No</td>
    <td class="even">$this->bankaccountno</td>
   </tr>
 
 </table>

</td>


<td>
EOF;
$this->showContactTable();
$this->showAddressTable();
$this->showFollowupTable();

echo <<< EOF
</td>

</tr>

<tr>
 <td style="width:2px" align="left">$view_button</td>
 <td align="left">$edit_button</td>
 <td width="1px">
<input style="display:none" type="button" name="vbutton" value="Print Employee Profile Cover" onclick="window.open('employeeprofile.php?employee_id=$this->employee_id')">
<input style="display:none" type="button" name="vbutton" value="Print Employee Profile Detail" onclick="window.open('viewemployeeprofile.php?employee_id=$this->employee_id')">
 </td>
</tr>

</table>

EOF;

 }
 
  public function showContactTable(){


	$sql="SELECT co.*, ad.address_name  FROM sim_contacts co
             left join sim_address ad on ad.address_id = co.address_id
             WHERE co.bpartner_id=$this->bpartner_id ORDER BY co.contacts_name DESC";

	$query=$this->xoopsDB->query($sql);
        $num_results = mysql_num_rows($query);

if($num_results>0){

	echo <<< EOF
	<table border='0' cellspacing='3'>
            <td colspan="7" class="searchformheader">Contacts</td>
  		<tbody>
    			<tr>
				<td class="searchformheader">No</td>
				<td class="searchformheader">Name</td>
				<td class="searchformheader">Email</td>
				<td class="searchformheader">HP</td>
                                <td class="searchformheader">Department</td>
                                <td class="searchformheader">Position</td>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$contacts_name=$row['contacts_name'];
		$email=$row['email'];
		$hpno=$row['hpno'];
		$address_name=$row['address_name'];
		$department=$row['department'];
		$position=$row['position'];

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>
			<td class="$rowtype" class="searchformheader">$i</td>
			<td class="$rowtype" class="searchformheader">$contacts_name</td>
			<td class="$rowtype" class="searchformheader">$email</td>
			<td class="$rowtype" class="searchformheader">$hpno</td>
                        <td class="$rowtype" class="searchformheader">$department</td>
			<td class="$rowtype" class="searchformheader">$position</td>
               </tr>
EOF;
	}
	echo  "</tr></tbody></table><br/>";
 }
 }

  public function showAddressTable(){


	$sql="SELECT ad.*, c.country_name, re.region_name  FROM sim_address ad
             left join sim_country c on c.country_id = ad.country_id
             left join sim_region re on re.region_id = ad.region_id
             WHERE ad.bpartner_id=$this->bpartner_id ORDER BY ad.address_name ASC";

	$query=$this->xoopsDB->query($sql);
        $num_results = mysql_num_rows($query);

if($num_results>0){

	echo <<< EOF
	<table border='0' cellspacing='3'>
            <td colspan="7" class="searchformheader">Address</td>
  		<tbody>
    			<tr>
				<td class="searchformheader">No</td>
				<td class="searchformheader">Address</td>
				<td class="searchformheader">Tel 1</td>
				<td class="searchformheader">Tel 2</td>
				<td class="searchformheader">Fax</td>
                                <td class="searchformheader">Ship.</td>
				<td class="searchformheader">Inv.</td>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$address_name=$row['address_name'];
		$tel_1=$row['tel_1'];
		$tel_2=$row['tel_2'];
		$fax=$row['fax'];
		$isshipment=$row['isshipment'];
                $isinvoice=$row['isinvoice'];
                $address_street =$row['address_street'];

                if($isshipment==1)
                      $isshipment="Y";
                else
                      $isshipment="N";
                if($isinvoice==1)
                      $isinvoice="Y";
                else
                      $isinvoice="N";

		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";

		echo <<< EOF

		<tr>
			<td class="$rowtype" class="searchformheader">$i</td>
			<td class="$rowtype" class="searchformheader">$address_name<br/>$address_street </td>
			<td class="$rowtype" class="searchformheader">$tel_1</td>
			<td class="$rowtype" class="searchformheader">$tel_2</td>
			<td class="$rowtype" class="searchformheader">$fax</td>
                        <td class="$rowtype" class="searchformheader">$isshipment</td>
			<td class="$rowtype" class="searchformheader">$isinvoice</td>
               </tr>
 	       <tr id="addressdetail" style="display:none">
			<td class="even" colspan="7">$i</td>
               </tr>
EOF;
	}
	echo  "</tr></tbody></table><br/>";
 }
 }

  public function showFollowupTable(){


	$sql="SELECT fol.*,folty.followuptype_name, emp.employee_name,emp.employee_altname  FROM sim_followup fol
             left join sim_followuptype folty on folty.followuptype_id = fol.followuptype_id
             inner join sim_hr_employee emp on emp.employee_id = fol.employee_id
             WHERE fol.bpartner_id=$this->bpartner_id ORDER BY fol.issuedate DESC";

	$query=$this->xoopsDB->query($sql);
        $num_results = mysql_num_rows($query);

if($num_results>0){

	echo <<< EOF
	<table border='0' cellspacing='3'>
            <td colspan="8" class="searchformheader">Follow Up</td>
  		<tbody>
    			<tr>
				<td class="searchformheader">No</td>
                                <td class="searchformheader">N.F. Name</td>
				<td class="searchformheader">P.I.C</td>
				<td class="searchformheader">Type</td>
				<td class="searchformheader">N.F. Date</td>
                        <td class="searchformheader">Active</td>
				<td class="searchformheader">Person</td>
                                <td class="searchformheader">Number</td>
   	</tr>
EOF;
	$rowtype="";
	$i=0;
	while ($row=$this->xoopsDB->fetchArray($query)){
		$i++;
		$followup_name=$row['followup_name'];
		$followuptype_name=$row['followuptype_name'];
		$issuedate=$row['issuedate'];
		$nextfollowupdate=$row['nextfollowupdate'];
		$contactperson=$row['contactperson'];
                $contactnumber=$row['contactnumber'];
                $isactive=$row['isactive'];
                $employee_altname=$row['employee_altname'];
                $employee_id=$row['employee_id'];
		if($rowtype=="odd")
			$rowtype="even";
		else
			$rowtype="odd";
                        if($isactive==1)
                            $isactive="Y";
                        else
                            $isactive="N";
		echo <<< EOF

		<tr>
			<td class="$rowtype" class="searchformheader">$i</td>
			<td class="$rowtype" class="searchformheader">$followup_name</td>
			<td class="$rowtype" class="searchformheader"><a href='../hr/employee.php?action=viewsummary&employee_id=$employee_id'>$employee_altname<a></td>
			<td class="$rowtype" class="searchformheader">$followuptype_name</td>
			<td class="$rowtype" class="searchformheader">$nextfollowupdate</td>
                <td class="$rowtype" class="searchformheader">$isactive</td>
                        <td class="$rowtype" class="searchformheader">$contactperson</td>
			<td class="$rowtype" class="searchformheader">$contactnumber</td>
               </tr>
EOF;
	}
	echo  "</tr></tbody></table><br/>";
 }
 }

  public function getNumber(){

       $this->bpartnerselected = substr($this->bpartnerselected,1);

        $array_bpartner = explode(',',$this->bpartnerselected);

        $i=0;
        $j=0;
        $result="";
        $this->log->showLog(3,"call getNumber");
        foreach($array_bpartner as $bpartner_no){
        $i++;

            //if($this->isselected[$i] == "on"){
            $j++;
            $sql = "select employee_hpno
                        from sim_hr_employee where employee_no = '$employee_no' ";

            $query=$this->xoopsDB->query($sql);

            if ($row=$this->xoopsDB->fetchArray($query)){
            $employee_name = $row['employee_name'];
           $employee_no = $row['employee_no'];
             $employee_hpno = $row['employee_hpno'];
                if($employee_hpno!="")
                    $result.=$employee_hpno."@";
            }
        //}
        }
        $result=substr_replace($result,"",-1);
        return $result;
    }

  public function isGroup($group_name){
     $sql = "select u.name, g.name as g_name from sim_users u, sim_groups g, sim_groups_users_link ug where u.uid=ug.uid and g.groupid=ug.groupid and u.uid=$this->createdby";
     $rs = $this->xoopsDB->query($sql);
     $allow = false;
     while ($row=$this->xoopsDB->fetchArray($rs)){
         //echo $row['g_name']." ".$group_name." ".$allow."|";

         if($row['g_name']==$group_name){
             $allow = true;
         }
     }
    // return $allow;
     return true;
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

  public function includeGeneralFile(){
      global $url;

echo <<< EOF
<script src="$url/modules/simantz/include/validatetext.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/popup.js" type="text/javascript"></script>
<script src="$url/browse.php?Frameworks/jquery/jquery.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.toolkit.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/firefox3_6fix.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/popup.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/themes/default/style.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.css">
EOF;

  }

    // start Contact section
    public function getContactform(){
      global $nitobigridthemes,$isadmin,$havewriteperm;

    if($isadmin==1){
        $grIdColumn=16; //define primary key column index, it will set as readonly afterwards (count from 0)
        //$deleteddefaultvalue_js="myGrid.getCellObject(rowNo,5).setValue(0);"; //if admin login got deleted column, during admin insert new record shall set it default =0 (not deleted)
        $changewidth="width='267'";

    }
    else{
        $grIdColumn=15;//define primary key column index for normal user
        $deleteddefaultvalue_js="";
            $changewidth="width='292'";
    }

    if($havewriteperm==1){ //user with write permission can edit grid, have button

       $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";

       $savectrl='';
       $addctrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
           <input name="btnSave" onclick="save()" value="Save" type="button">';
        $alloweditgrid= "col!=$grIdColumn";
    }
    else{ //user dun have write permission, cannot save grid
        $savectrl="";

       $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
       $alloweditgrid= "false";
    }

    $timestamp= date("Y-m-d", time()) ;
echo <<< EOF
<link rel="stylesheet" type="text/css" href="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.css" />
<script type="text/javascript" src="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.js"></script>
  <script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){nitobi.loadComponent('DataboundGrid');}));

     function search(){
        var grid = nitobi.getGrid("DataboundGrid");
        //reload grid data
	grid.dataBind();

    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        return 0;
    }

    //after grid html render properly, set focus on it. It is important when use choose particular cell but
    // immediately press search again. From screen we won't detect cell is selected infact from javascript
    // detect selected
   function dataready(){

       var  g = nitobi.getGrid('DataboundGrid');
        g.move(0,0);//need to trigger relative position 0,0 in for next code able to highlight at screen
        var selRow = g.getSelectedRow();

    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();



        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Record saved successfully</a>";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                         search();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	search();

                popup('popUpDiv');

        	return false;
        	}
    }

    //if save_data have error, trigger this function
    function showError(){

        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();

        var errorMessage = dataSource.getHandlerError();



        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">"+errorMessage+"</a><br/>";
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var  myGrid = nitobi.getGrid('DataboundGrid');
                    var myCell = myGrid.getCellObject(row, col);
                    myCell.edit();
    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('DataboundGrid');
        g.insertAfterCurrentRow();
    }

    //trigger save activity from javascript
   function save()
     {
    if(validateEmpty()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DataboundGrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
     	  var g= nitobi.getGrid('DataboundGrid');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
	    search();
    	   }
	}
      }
      else{
      document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Contact name.</b><br/>";

      }
    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

    function checkAllowEdit(eventArgs){
	var g= nitobi.getGrid('DataboundGrid');
        col=eventArgs.getCell().getColumn();
       if($alloweditgrid) //if user have permission to edit the cell, control primary key column read only at here too
        return true;
        else
        return false;
        }


    //after insert a new line will automatically fill in some value here
      function setDefaultValue(eventArgs)
       {
       var myGrid = eventArgs.getSource();
       var r = eventArgs.getRow();
       var rowNo = r.Row;
              $deleteddefaultvalue_js
       myGrid.selectCellByCoords(rowNo, 0);
    }

    function beforeDelete(){
            if(confirm('Delete this record? Data will save into database immediately.')){
                    document.getElementById("afterconfirm").value=1;
  //popup('popUpDiv');
                    return true;
            }
                    else{
                    document.getElementById("afterconfirm").value=0;
                    return false;
                    }
     }
    function viewlog(){
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var cellObj = g.getCellValue(selRow, 4);
      window.open(cellObj,"");
    }
   function validateEmpty(){

        var grid= nitobi.getGrid('DataboundGrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var name ="";

        for( var i = 0; i < total_row; i++ ) {

        var celly = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq

           name = celly.getValue();
           if(name=="")
           {
            isallow = false;
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }

        function valiedatetelno(){
       var grid= nitobi.getGrid('DataboundGrid');
       var selRow = grid.getSelectedRow();
       var selCol = grid.getSelectedColumn();
       var celly = grid.getCellObject( selRow, selCol);
       var no = celly.getValue();

       if(no!="") {
           if((no.replace(/[0-9]/g,'')).replace(/-/g,'') !=""){
             celly.setValue("");alert("Contact number format error.");
           }

        }
     }
</script>
<div id='blanket' style='display:none;'></div>
<div id='popUpDiv' style='display:none;verticle-align:center'>

     <div id='popupmessage' style='text-align:center'></div>
     <div id='progressimage' style='text-align:center'><img src='../simantz/images/ajax_indicator_01.gif'></div>
</div>

<div align="center">
<table style="width:700px;">
    <tr>
      <td style='text-align: center;' colspan='8' class="searchformheader">Contact Info</td>
    </tr>
<tr><td align="left" style="height:27px;">$addctrl</td></tr>

<tr><td align="center">

<ntb:grid id="DataboundGrid"
     mode="nonpaging"
     toolbarenabled='false'
     $permctrl
     onhtmlreadyevent="dataready()"
     singleclickeditenabled="true"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="bpartner.php?action=searchcontact&bpartner_id=$this->bpartner_id"
     savehandler="bpartner.php?action=savecontact&bpartner_id=$this->bpartner_id"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     onafterrowinsertevent="setDefaultValue(eventArgs)"
     rowhighlightenabled="true"
     width="943"
     height="200"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes">

 <ntb:columns>
        
   <ntb:textcolumn classname="{\$rh}" label="Greeting" width="60" xdatafld="greeting" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Contact Name" width="140" xdatafld="contacts_name" sortenabled="true"></ntb:textcolumn>
        
   <ntb:textcolumn classname="{\$rh}" label="Alternate Name" width="90" xdatafld="alternatename" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Position" width="100" xdatafld="position" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Department" width="100" xdatafld="department" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Races" width="80" xdatafld="races_id" sortenabled="true">
           <ntb:listboxeditor gethandler="bpartner.php?action=races" displayfields="races_name" valuefield="races_id" ></ntb:listboxeditor>
        </ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Religion" width="80" xdatafld="religion_id" sortenabled="true">
           <ntb:listboxeditor gethandler="bpartner.php?action=religion" displayfields="religion_name" valuefield="religion_id" ></ntb:listboxeditor>
        </ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Email" width="100" xdatafld="email" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Tel 1" width="70" xdatafld="tel_1" sortenabled="true"  onaftercelleditevent="javascript:valiedatetelno()"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Tel 2" width="70" xdatafld="tel_2" sortenabled="true"  onaftercelleditevent="javascript:valiedatetelno()"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Hand Phone" width="70" xdatafld="hpno" sortenabled="true"  onaftercelleditevent="javascript:valiedatetelno()"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Fax" width="70" xdatafld="fax" sortenabled="true"  onaftercelleditevent="javascript:valiedatetelno()"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Address" width="60" xdatafld="address_id" sortenabled="true">
           <ntb:lookupeditor delay="1000" gethandler="bpartner.php?action=addresslist&bpartner_id=$this->bpartner_id" displayfields="address_name" valuefield="address_id" ></ntb:lookupeditor>
        </ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Description" xdatafld="description" ><ntb:textareaeditor></ntb:textareaeditor></ntb:textcolumn>

   <ntb:textcolumn label="Active" width="45" xdatafld="isactive" sortenabled="true"  classname="{\$rh}" align="center">
        <ntb:checkboxeditor datasource="[{value:'1',display:''},{value:'0',display:''}]" checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value"></ntb:checkboxeditor>
   </ntb:textcolumn>
EOF;
//only admin user will see record info and isdeleted column
if($isadmin==1)
{
echo<<< EOF
<ntb:textcolumn  label="Log"   xdatafld="info"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlog()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
EOF;
}
 echo <<< EOF
      <ntb:numbercolumn   label="ID"  width="0" xdatafld="contacts_id" mask="###0" sortenabled="false">
                    </ntb:numbercolumn>
         <ntb:textcolumn  label="Del"   xdatafld=""    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebutton()">
            <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>
</ntb:columns>
</ntb:grid>

</td></tr>
<tr><td align="left">$savectrl</td></tr>
<tr><td align="left">
<input id='afterconfirm' value='0' type='hidden'>

<br> <div id="msgbox" class="blockContent"></div>
</td></tr></table></div>

EOF;
  }

    public function showContact($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_contacts";

   $this->log->showLog(2,"Access showContact($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno, contacts_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("greeting");
     	$getHandler->DefineField("contacts_name");
     	$getHandler->DefineField("alternatename");
     	$getHandler->DefineField("position");
        $getHandler->DefineField("department");
        $getHandler->DefineField("races_id");
     	$getHandler->DefineField("religion_id");
     	$getHandler->DefineField("tel_1");
        $getHandler->DefineField("tel_2");
        $getHandler->DefineField("email");
        $getHandler->DefineField("hpno");
     	$getHandler->DefineField("fax");
     	$getHandler->DefineField("uid");
        $getHandler->DefineField("address_id");
        $getHandler->DefineField("description");
        $getHandler->DefineField("isactive");
        $getHandler->DefineField("contacts_id");
        $getHandler->DefineField("rh");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
        $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {
          if($rh=="even")
            $rh="odd";
          else
            $rh="even";
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['contacts_id']);
             $getHandler->DefineRecordFieldValue("greeting", $row['greeting']);
             $getHandler->DefineRecordFieldValue("contacts_name",$row['contacts_name']);
             $getHandler->DefineRecordFieldValue("alternatename", $row['alternatename']);
             $getHandler->DefineRecordFieldValue("position", $row['position']);
             $getHandler->DefineRecordFieldValue("department",$row['department']);
             $getHandler->DefineRecordFieldValue("races_id", $row['races_id']);
             $getHandler->DefineRecordFieldValue("religion_id",$row['religion_id']);
             $getHandler->DefineRecordFieldValue("tel_1", $row['tel_1']);
             $getHandler->DefineRecordFieldValue("tel_2", $row['tel_2']);
             $getHandler->DefineRecordFieldValue("email",$row['email']);
             $getHandler->DefineRecordFieldValue("hpno",$row['hpno']);
             $getHandler->DefineRecordFieldValue("fax", $row['fax']);
             $getHandler->DefineRecordFieldValue("uid", $row['uid']);
             $getHandler->DefineRecordFieldValue("address_id",$row['address_id']);
             $getHandler->DefineRecordFieldValue("description", $row['description']);
             $getHandler->DefineRecordFieldValue("isactive",$row['isactive']);
             $getHandler->DefineRecordFieldValue("info","../simantz/recordinfo.php?id=".$row['contacts_id']."&tablename=sim_contacts&idname=contacts_id&title=Contacts");
             $getHandler->DefineRecordFieldValue("contacts_id",$row['contacts_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showContact()");
    }

    public function saveContact(){
        $this->log->showLog(3,"Access saveContact");
            include "../simantz/class/nitobi.xml.php";
            include_once "../simantz/class/Save_Data.inc.php";

            global $xoopsDB,$xoopsUser;
            $saveHandler = new EBASaveHandler();
            $saveHandler->ProcessRecords();
            $timestamp=date("Y-m-d H:i:s",time());
            $createdby=$xoopsUser->getVar('uid');
            $uname=$xoopsUser->getVar('uname');
            $uid=$xoopsUser->getVar('uid');


        $tablename="sim_contacts";

            $save = new Save_Data();
            $insertCount = $saveHandler->ReturnInsertCount();
            $this->log->showLog(3,"Start Insert($insertCount records $this->employee_id)");

    if ($insertCount > 0)
    {
          $arrfield=array("greeting", "contacts_name", "alternatename","position","department",
                          "races_id","religion_id","tel_1","tel_2","email",

                          "hpno","fax","address_id","description",
                          "isactive","created","createdby","updated","updatedby","bpartner_id");
          $arrfieldtype=array('%s','%s','%s','%s','%s',
                              '%d','%d','%s','%s','%s',

                              '%s','%s','%d','%s',
                              '%d','%s','%d','%s','%d','%d');

    // Yes there are INSERTs to perform...
     for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
     {

         $arrvalue=array($saveHandler->ReturnInsertField($currentRecord,"greeting"),
                    $saveHandler->ReturnInsertField($currentRecord,"contacts_name"),
                    $saveHandler->ReturnInsertField($currentRecord,"alternatename"),
                    $saveHandler->ReturnInsertField($currentRecord,"position"),
                    $saveHandler->ReturnInsertField($currentRecord,"department"),

                    $saveHandler->ReturnInsertField($currentRecord,"races_id"),
                    $saveHandler->ReturnInsertField($currentRecord,"religion_id"),
                    $saveHandler->ReturnInsertField($currentRecord,"tel_1"),
                    $saveHandler->ReturnInsertField($currentRecord,"tel_2"),
                    $saveHandler->ReturnInsertField($currentRecord,"email"),

                    $saveHandler->ReturnInsertField($currentRecord,"hpno"),
                    $saveHandler->ReturnInsertField($currentRecord,"fax"),
                    $saveHandler->ReturnInsertField($currentRecord,"address_id"),
                    $saveHandler->ReturnInsertField($currentRecord,"description"),

                    $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                    $timestamp,
                    $createdby,
                    $timestamp,
                    $createdby,
                    $this->bpartner_id);
         $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "contacts_name");
         $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"contacts_id");
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
      // Now we execute this query
     }
    }

    $updateCount = $saveHandler->ReturnUpdateCount();
    $this->log->showLog(3,"Start update($updateCount records)");

    if ($updateCount > 0)
    {
          $arrfield=array("greeting", "contacts_name", "alternatename","position","department",
                          "races_id","religion_id","tel_1","tel_2","email",

                          "hpno","fax","address_id","description",
                          "isactive","updated","updatedby");
          $arrfieldtype=array('%s','%s','%s','%s','%s',
                              '%d','%d','%s','%s','%s',

                              '%s','%s','%d','%s',
                              '%d','%s','%d');
     // Yes there are UPDATEs to perform...

     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
             $this->log->showLog(3,"***updating record($currentRecord),new contacts_name:".
                    $saveHandler->ReturnUpdateField($currentRecord, "contacts_name").",id:".
                    $saveHandler->ReturnUpdateField($currentRecord, "contacts_id")."\n");
             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "contacts_name");

     }

     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
     {
         $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord,"greeting"),
                    $saveHandler->ReturnUpdateField($currentRecord,"contacts_name"),
                    $saveHandler->ReturnUpdateField($currentRecord,"alternatename"),
                    $saveHandler->ReturnUpdateField($currentRecord,"position"),
                    $saveHandler->ReturnUpdateField($currentRecord,"department"),
                    $saveHandler->ReturnUpdateField($currentRecord,"races_id"),
                    $saveHandler->ReturnUpdateField($currentRecord,"religion_id"),
                    $saveHandler->ReturnUpdateField($currentRecord,"tel_1"),
                    $saveHandler->ReturnUpdateField($currentRecord,"tel_2"),
                    $saveHandler->ReturnUpdateField($currentRecord,"email"),
                    $saveHandler->ReturnUpdateField($currentRecord,"hpno"),
                    $saveHandler->ReturnUpdateField($currentRecord,"fax"),
                    $saveHandler->ReturnUpdateField($currentRecord,"address_id"),
                    $saveHandler->ReturnUpdateField($currentRecord,"description"),
                    $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                    $timestamp,
                    $createdby);

            $this->log->showLog(3,"***updating record($currentRecord),new contacts_name:".
                    $saveHandler->ReturnUpdateField($currentRecord, "contacts_name").",id:".
                  $saveHandler->ReturnUpdateField($currentRecord,"contacts_id")."\n");

             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "contacts_name");

             $save->UpdateRecord($tablename, "contacts_id", $saveHandler->ReturnUpdateField($currentRecord,"contacts_id"),
                        $arrfield, $arrvalue, $arrfieldtype,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }

     }
    }

    $ispurge=0;
    $deleteCount = $saveHandler->ReturnDeleteCount();
    $this->log->showLog(3,"Start delete/purge($deleteCount records)");
    //include "class/Country.inc.php";
    //$o = new Country();

    if ($deleteCount > 0){
      for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
        $record_id=$saveHandler->ReturnDeleteField($currentRecord);

       // $this->fetchContacts($record_id);
        $controlvalue=$this->contacts_name;
        $isdeleted=$this->isdeleted;

        $save->DeleteRecord("sim_contacts","contacts_id",$record_id,$controlvalue,1);
      }

      }

    if($this->failfeedback!="")
    $this->failfeedback="Warning!<br/>\n".$this->failfeedback;
    $saveHandler->setErrorMessage($this->failfeedback);
    $saveHandler->CompleteSave();

    }

    public function fetchContact($portfolioline_id){
	$this->log->showLog(3,"Fetching contacts detail into class BPartner.php.<br>");

	$sql="SELECT * from sim_contacts where contacts_id=$contacts_id";

	$this->log->showLog(4,"Productcontacts->fetchContact, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->contacts_name=$row["contacts_name"];

   	$this->log->showLog(4,"Productcontacts->fetchContact,database fetch into class successfully");
	$this->log->showLog(4,"contacts_name:$this->contacts_name");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Productcontacts->fetchContact,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  }
  // end of member function Contact



    // start Address section
    public function getAddressform(){
      global $nitobigridthemes,$isadmin,$havewriteperm;

    if($isadmin==1){
        $grIdColumn=16; //define primary key column index, it will set as readonly afterwards (count from 0)
       // $deleteddefaultvalue_js="myGrid.getCellObject(rowNo,5).setValue(0);"; //if admin login got deleted column, during admin insert new record shall set it default =0 (not deleted)
        $changewidth="width='267'";

    }
    else{
        $grIdColumn=14;//define primary key column index for normal user
        $deleteddefaultvalue_js="";
            $changewidth="width='292'";
    }

    if($havewriteperm==1){ //user with write permission can edit grid, have button

       $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";

       $savectrl='';
       $addctrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
           <input name="btnSave" onclick="save()" value="Save" type="button">';
        $alloweditgrid= "col!=$grIdColumn";
    }
    else{ //user dun have write permission, cannot save grid
        $savectrl="";

       $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
       $alloweditgrid= "false";
    }

    $timestamp= date("Y-m-d", time()) ;
echo <<< EOF
<link rel="stylesheet" type="text/css" href="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.css" />
<script type="text/javascript" src="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.js"></script>
  <script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){nitobi.loadComponent('DataboundGrid');}));

     function search(){
        var grid = nitobi.getGrid("DataboundGrid");
        //reload grid data
	grid.dataBind();

    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        return 0;
    }

    //after grid html render properly, set focus on it. It is important when use choose particular cell but
    // immediately press search again. From screen we won't detect cell is selected infact from javascript
    // detect selected
   function dataready(){

       var  g = nitobi.getGrid('DataboundGrid');
        g.move(0,0);//need to trigger relative position 0,0 in for next code able to highlight at screen
        var selRow = g.getSelectedRow();

    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();



        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Record saved successfully</a>";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                         search();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	search();

                popup('popUpDiv');

        	return false;
        	}
    }

    //if save_data have error, trigger this function
    function showError(){

        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();

        var errorMessage = dataSource.getHandlerError();



        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">"+errorMessage+"</a><br/>";
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var  myGrid = nitobi.getGrid('DataboundGrid');
                    var myCell = myGrid.getCellObject(row, col);
                    myCell.edit();
    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('DataboundGrid');
        g.insertAfterCurrentRow();
    }

    //trigger save activity from javascript
   function save()
     {
    if(validateEmpty()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DataboundGrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
     	  var g= nitobi.getGrid('DataboundGrid');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
	    search();
    	   }
	}
      }
      else{
      document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Address name.</b><br/>";

      }
    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

    function checkAllowEdit(eventArgs){
	var g= nitobi.getGrid('DataboundGrid');
        col=eventArgs.getCell().getColumn();
       if($alloweditgrid) //if user have permission to edit the cell, control primary key column read only at here too
        return true;
        else
        return false;
        }


    //after insert a new line will automatically fill in some value here
      function setDefaultValue(eventArgs)
       {
       var myGrid = eventArgs.getSource();
       var r = eventArgs.getRow();
       var rowNo = r.Row;
              $deleteddefaultvalue_js
       myGrid.selectCellByCoords(rowNo, 0);
    }

    function beforeDelete(){
            if(confirm('Delete this record? Data will save into database immediately.')){
                    document.getElementById("afterconfirm").value=1;
  //popup('popUpDiv');
                    return true;
            }
                    else{
                    document.getElementById("afterconfirm").value=0;
                    return false;
                    }
     }
    function viewlog(){
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
      window.open(cellObj,"");
    }
   function validateEmpty(){

        var grid= nitobi.getGrid('DataboundGrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var name ="";

        for( var i = 0; i < total_row; i++ ) {

        var celly = grid.getCellObject( i, 0);//1st para : row , 2nd para : column seq

           name = celly.getValue();
           if(name=="")
           {
            isallow = false;
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }

    function valiedatetelno(){
       var grid= nitobi.getGrid('DataboundGrid');
       var selRow = grid.getSelectedRow();
       var selCol = grid.getSelectedColumn();
       var celly = grid.getCellObject( selRow, selCol);
       var no = celly.getValue();

       if(no!="") {
           if((no.replace(/[0-9]/g,'')).replace(/-/g,'') !=""){
             celly.setValue("");alert("Contact number format error.");
           }

        }
     }
</script>
<div id='blanket' style='display:none;'></div>
<div id='popUpDiv' style='display:none;verticle-align:center'>

     <div id='popupmessage' style='text-align:center'></div>
     <div id='progressimage' style='text-align:center'><img src='../simantz/images/ajax_indicator_01.gif'></div>
</div>

<div align="center">
<table style="width:700px;">
    <tr>
      <td style='text-align: center;' colspan='8' class="searchformheader">Address Info</td>
    </tr>
<tr><td align="left" style="height:27px;">$addctrl</td></tr>

<tr><td align="center">

<ntb:grid id="DataboundGrid"
     mode="nonpaging"
     toolbarenabled='false'
     $permctrl
     onhtmlreadyevent="dataready()"
     singleclickeditenabled="true"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="bpartner.php?action=searchaddress&bpartner_id=$this->bpartner_id"
     savehandler="bpartner.php?action=saveaddress&bpartner_id=$this->bpartner_id"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     onafterrowinsertevent="setDefaultValue(eventArgs)"
     rowhighlightenabled="true"
     rowheight="70"
     width="943"
     height="200"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes">

 <ntb:columns>

   <ntb:textcolumn classname="{\$rh}" label="Name" xdatafld="address_name" editable="true" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Street" width="150" xdatafld="address_street" editable="true" sortenabled="true"><ntb:textareaeditor  ></ntb:textareaeditor></ntb:textcolumn>

   <ntb:numbercolumn classname="{\$rh}" label="Postcode" width="55" xdatafld="address_postcode" editable="true" sortenabled="true" mask="###0"></ntb:numbercolumn>

   <ntb:textcolumn classname="{\$rh}" label="City" width="130" xdatafld="address_city" editable="true" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Region" width="90" xdatafld="region_id" editable="true" >
            <ntb:lookupeditor delay="1000" gethandler="bpartner.php?action=regionlist" displayfields="region_name" valuefield="region_id" ></ntb:lookupeditor>
        </ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Country" width="90" xdatafld="country_id" sortenabled="true">
           <ntb:lookupeditor delay="1000" gethandler="bpartner.php?action=countrylist" displayfields="country_name" valuefield="country_id" ></ntb:lookupeditor>
        </ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Tel 1" width="70" xdatafld="tel_1" sortenabled="true" onaftercelleditevent="javascript:valiedatetelno()"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Tel 2" width="70" xdatafld="tel_2" sortenabled="true" onaftercelleditevent="javascript:valiedatetelno()"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Fax" width="70" xdatafld="fax" sortenabled="true" onaftercelleditevent="javascript:valiedatetelno()"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Invoice" width="60" xdatafld="isinvoice" sortenabled="true" align="center">
           <ntb:checkboxeditor datasource="[{valuedd:'1',displaydd:''},{valuedd:'0',displaydd:''}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="displaydd" valuefield="valuedd">
           </ntb:checkboxeditor>
        </ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Shipment" width="60" xdatafld="isshipment" sortenabled="true" align="center">
           <ntb:checkboxeditor datasource="[{valuedd:'1',displaydd:''},{valuedd:'0',displaydd:''}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="displaydd" valuefield="valuedd">
           </ntb:checkboxeditor>
        </ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Active" width="50" xdatafld="isactive" sortenabled="true" align="center">
           <ntb:checkboxeditor datasource="[{valuedd:'1',displaydd:''},{valuedd:'0',displaydd:''}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="displaydd" valuefield="valuedd">
           </ntb:checkboxeditor>
        </ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" $changewidth label="Description" xdatafld="description" ><ntb:textareaeditor></ntb:textareaeditor></ntb:textcolumn>

EOF;
//only admin user will see record info and isdeleted column
if($isadmin==1)
{
echo<<< EOF
<ntb:textcolumn  label="Log"   xdatafld="info"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlog()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
EOF;
}
 echo <<< EOF
      <ntb:numbercolumn   label="ID"  width="0" xdatafld="address_id" mask="###0" sortenabled="false">
                    </ntb:numbercolumn>
         <ntb:textcolumn  label="Del"   xdatafld=""    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebutton()">
            <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>
</ntb:columns>
</ntb:grid>

</td></tr>
<tr><td align="left">$savectrl</td></tr>
<tr><td align="left">
<input id='afterconfirm' value='0' type='hidden'>

<br> <div id="msgbox" class="blockContent"></div>
</td></tr></table></div>

EOF;
  }

    public function showAddress($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_address";

   $this->log->showLog(2,"Access showAddress($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno, address_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
   
     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("address_name");
     	$getHandler->DefineField("address_street");
     	$getHandler->DefineField("address_postcode");
     	$getHandler->DefineField("address_city");
        $getHandler->DefineField("region_id");
        $getHandler->DefineField("country_id");
     	$getHandler->DefineField("tel_1");
     	$getHandler->DefineField("tel_2");
     	$getHandler->DefineField("fax");
        $getHandler->DefineField("isinvoice");
        $getHandler->DefineField("isshipment");
        $getHandler->DefineField("isactive");
        $getHandler->DefineField("description");
        $getHandler->DefineField("info");
        $getHandler->DefineField("address_id");
        $getHandler->DefineField("rh");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
                    $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {
          if($rh=="even")
            $rh="odd";
          else
            $rh="even";
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['address_id']);
             $getHandler->DefineRecordFieldValue("address_name", $row['address_name']);
             $getHandler->DefineRecordFieldValue("address_street",$row['address_street']);
             $getHandler->DefineRecordFieldValue("address_postcode", $row['address_postcode']);
             $getHandler->DefineRecordFieldValue("address_city", $row['address_city']);
             $getHandler->DefineRecordFieldValue("region_id",$row['region_id']);
             $getHandler->DefineRecordFieldValue("country_id", $row['country_id']);
             $getHandler->DefineRecordFieldValue("tel_1",$row['tel_1']);
             $getHandler->DefineRecordFieldValue("tel_2", $row['tel_2']);
             $getHandler->DefineRecordFieldValue("fax", $row['fax']);
             $getHandler->DefineRecordFieldValue("isinvoice",$row['isinvoice']);
             $getHandler->DefineRecordFieldValue("isshipment", $row['isshipment']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("description",$row['description']);
             $getHandler->DefineRecordFieldValue("info","../simantz/recordinfo.php?id=".$row['address_id']."&tablename=sim_address&idname=address_id&title=Business Address");
             $getHandler->DefineRecordFieldValue("address_id",$row['address_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showAddress()");
    }

    public function saveAddress(){
        $this->log->showLog(3,"Access savePortfolioline");
            include "../simantz/class/nitobi.xml.php";
            include_once "../simantz/class/Save_Data.inc.php";

            global $xoopsDB,$xoopsUser,$defaultorganization_id;
            $saveHandler = new EBASaveHandler();
            $saveHandler->ProcessRecords();
            $timestamp=date("Y-m-d H:i:s",time());
            $createdby=$xoopsUser->getVar('uid');
            $uname=$xoopsUser->getVar('uname');
            $uid=$xoopsUser->getVar('uid');


        $tablename="sim_address";

            $save = new Save_Data();
            $insertCount = $saveHandler->ReturnInsertCount();
            $this->log->showLog(3,"Start Insert($insertCount records)");

    if ($insertCount > 0)
    {
          $arrfield=array("address_name", "address_street", "address_postcode","address_city","region_id","country_id",
                          "tel_1","tel_2","fax","isinvoice","isshipment","description",
                          "created","createdby","updated","updatedby","bpartner_id","isactive","organization_id");
          $arrfieldtype=array('%s','%s','%d','%s','%d','%d',
                              '%s','%s','%s','%d','%d','%s',
                              '%s','%d','%s','%d','%d','%d','%d');

    // Yes there are INSERTs to perform...
     for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
     {

         $arrvalue=array($saveHandler->ReturnInsertField($currentRecord,"address_name"),
                    $saveHandler->ReturnInsertField($currentRecord,"address_street"),
                    $saveHandler->ReturnInsertField($currentRecord,"address_postcode"),
                    $saveHandler->ReturnInsertField($currentRecord,"address_city"),
                    $saveHandler->ReturnInsertField($currentRecord,"region_id"),
                    $saveHandler->ReturnInsertField($currentRecord,"country_id"),
                    $saveHandler->ReturnInsertField($currentRecord,"tel_1"),
                    $saveHandler->ReturnInsertField($currentRecord,"tel_2"),
                    $saveHandler->ReturnInsertField($currentRecord,"fax"),
                    $saveHandler->ReturnInsertField($currentRecord,"isinvoice"),
                    $saveHandler->ReturnInsertField($currentRecord,"isshipment"),
                    $saveHandler->ReturnInsertField($currentRecord,"description"),
                    $timestamp,
                    $createdby,
                    $timestamp,
                    $createdby,
                    $this->bpartner_id,
                    $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                    $defaultorganization_id);
         $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "address_name");
         $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"address_id");
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
      // Now we execute this query
     }
    }

    $updateCount = $saveHandler->ReturnUpdateCount();
    $this->log->showLog(3,"Start update($updateCount records)");

    if ($updateCount > 0)
    {
          $arrfield=array("address_name", "address_street", "address_postcode","address_city","region_id","country_id",
                          "tel_1","tel_2","fax","isinvoice","isshipment","description",
                          "updated","updatedby","isactive");
          $arrfieldtype=array('%s','%s','%d','%s','%d','%d',
                              '%s','%s','%s','%d','%d','%s',
                              '%s','%d','%d');
     // Yes there are UPDATEs to perform...

     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
             $this->log->showLog(3,"***updating record($currentRecord),new address_name:".
                    $saveHandler->ReturnUpdateField($currentRecord, "address_name").",id:".
                    $saveHandler->ReturnUpdateField($currentRecord,"address_id")."\n");
             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "address_name");

     }

     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
     {
   
         $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord,"address_name"),
                    $saveHandler->ReturnUpdateField($currentRecord,"address_street"),
                    $saveHandler->ReturnUpdateField($currentRecord,"address_postcode"),
                    $saveHandler->ReturnUpdateField($currentRecord,"address_city"),
                    $saveHandler->ReturnUpdateField($currentRecord,"region_id"),
                    $saveHandler->ReturnUpdateField($currentRecord,"country_id"),
                    $saveHandler->ReturnUpdateField($currentRecord,"tel_1"),
                    $saveHandler->ReturnUpdateField($currentRecord,"tel_2"),
                    $saveHandler->ReturnUpdateField($currentRecord,"fax"),
                    $saveHandler->ReturnUpdateField($currentRecord,"isinvoice"),
                    $saveHandler->ReturnUpdateField($currentRecord,"isshipment"),
                    $saveHandler->ReturnUpdateField($currentRecord,"description"),
                    $timestamp,
                    $createdby,
                    $saveHandler->ReturnUpdateField($currentRecord,"isactive"),);

            $this->log->showLog(3,"***updating record($currentRecord),new address_name:".
                    $saveHandler->ReturnUpdateField($currentRecord, "address_name").",id:".
                  $saveHandler->ReturnUpdateField($currentRecord,"address_id")."\n");

             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "address_name");

             $save->UpdateRecord($tablename, "address_id", $saveHandler->ReturnUpdateField($currentRecord,"address_id"),
                        $arrfield, $arrvalue, $arrfieldtype,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }

     }
    }

    $ispurge=0;
    $deleteCount = $saveHandler->ReturnDeleteCount();
    $this->log->showLog(3,"Start delete/purge($deleteCount records)");
    //include "class/Country.inc.php";
    //$o = new Country();

    if ($deleteCount > 0){
      for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
        $record_id=$saveHandler->ReturnDeleteField($currentRecord);

        $this->fetchAddress($record_id);
        $controlvalue=$this->address_name;
        $isdeleted=$this->isdeleted;

        $save->DeleteRecord("sim_address","address_id",$record_id,$controlvalue,1);
      }

      }

    if($this->failfeedback!="")
    $this->failfeedback="Warning!<br/>\n".$this->failfeedback;
    $saveHandler->setErrorMessage($this->failfeedback);
    $saveHandler->CompleteSave();

    }

    public function fetchAddress($portfolioline_id){
	$this->log->showLog(3,"Fetching fetchAddress detail into class BPartner.php.<br>");

	$sql="SELECT * from sim_address where portfolioline_id=$portfolioline_id";

	$this->log->showLog(4,"ProductAddress->fetchAddress, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->address_name=$row["address_name"];
		$this->address_street=$row["address_street"];
		$this->address_postcode=$row['address_postcode'];
		$this->address_city= $row['address_city'];
                $this->region_id=$row["region_id"];
		$this->country_id=$row["country_id"];
		$this->tel_1=$row['tel_1'];
		$this->tel_2= $row['tel_2'];
		$this->fax=$row['fax'];
                $this->isinvoice=$row["isinvoice"];
		$this->isshipment=$row["isshipment"];
		$this->description=$row['description'];

   	$this->log->showLog(4,"ProductAddress->fetchAddress,database fetch into class successfully");
	$this->log->showLog(4,"address_name:$this->address_name");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"ProductAddress->fetchAddress,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  }
  // end of member function fetchPortfolioline




    // start Portfolioline section
    public function getFollowupform(){
      global $nitobigridthemes,$isadmin,$havewriteperm;

    if($isadmin==1){
        $grIdColumn=10; //define primary key column index, it will set as readonly afterwards (count from 0)
       // $deleteddefaultvalue_js="myGrid.getCellObject(rowNo,5).setValue(0);"; //if admin login got deleted column, during admin insert new record shall set it default =0 (not deleted)
        $changewidth="width='267'";

    }
    else{
        $grIdColumn=9;//define primary key column index for normal user
        $deleteddefaultvalue_js="";
            $changewidth="width='292'";
    }

    if($havewriteperm==1){ //user with write permission can edit grid, have button

       $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";

       $savectrl='';
       $addctrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
           <input name="btnSave" onclick="save()" value="Save" type="button">';
        $alloweditgrid= "col!=$grIdColumn";
    }
    else{ //user dun have write permission, cannot save grid
        $savectrl="";

       $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
       $alloweditgrid= "false";
    }

    $timestamp= date("Y-m-d", time()) ;
echo <<< EOF
<link rel="stylesheet" type="text/css" href="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.css" />
<script type="text/javascript" src="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.js"></script>
  <script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){nitobi.loadComponent('DataboundGrid');}));

     function search(){
        var grid = nitobi.getGrid("DataboundGrid");
        //reload grid data
	grid.dataBind();

    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        return 0;
    }

    //after grid html render properly, set focus on it. It is important when use choose particular cell but
    // immediately press search again. From screen we won't detect cell is selected infact from javascript
    // detect selected
   function dataready(){

       var  g = nitobi.getGrid('DataboundGrid');
        g.move(0,0);//need to trigger relative position 0,0 in for next code able to highlight at screen
        var selRow = g.getSelectedRow();

    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();



        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Record saved successfully</a>";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                         search();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	search();

                popup('popUpDiv');

        	return false;
        	}
    }

    //if save_data have error, trigger this function
    function showError(){

        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();

        var errorMessage = dataSource.getHandlerError();



        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">"+errorMessage+"</a><br/>";
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var  myGrid = nitobi.getGrid('DataboundGrid');
                    var myCell = myGrid.getCellObject(row, col);
                    myCell.edit();
    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('DataboundGrid');
        g.insertAfterCurrentRow();
    }

    //trigger save activity from javascript
   function save()
     {
    if(validateEmpty()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DataboundGrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
     	  var g= nitobi.getGrid('DataboundGrid');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
	    search();
    	   }
	}
      }

    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

    function checkAllowEdit(eventArgs){
	var g= nitobi.getGrid('DataboundGrid');
        col=eventArgs.getCell().getColumn();
       if($alloweditgrid) //if user have permission to edit the cell, control primary key column read only at here too
        return true;
        else
        return false;
        }


    //after insert a new line will automatically fill in some value here
      function setDefaultValue(eventArgs)
       {
       var myGrid = eventArgs.getSource();
       var r = eventArgs.getRow();
       var rowNo = r.Row;
              $deleteddefaultvalue_js
       myGrid.selectCellByCoords(rowNo, 0);
    }

    function beforeDelete(){
            if(confirm('Delete this record? Data will save into database immediately.')){
                    document.getElementById("afterconfirm").value=1;
  //popup('popUpDiv');
                    return true;
            }
                    else{
                    document.getElementById("afterconfirm").value=0;
                    return false;
                    }
     }
    function viewlog(){
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
      window.open(cellObj,"");
    }
   function validateEmpty(){

        var grid= nitobi.getGrid('DataboundGrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var title ="";
        var type ="";
        var pic ="";
        var cname ="";

        for( var i = 0; i < total_row; i++ ) {

        var titlecelly = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq
        var typecelly = grid.getCellObject( i, 2);//1st para : row , 2nd para : column seq
        var piccelly = grid.getCellObject( i, 3);//1st para : row , 2nd para : column seq
        var cnamecelly = grid.getCellObject( i, 5);//1st para : row , 2nd para : column seq

        title = titlecelly.getValue();
        type = typecelly.getValue();
        pic = piccelly.getValue();
        cname = cnamecelly.getValue();
    
           if(cname=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Contact name.</b><br/>";
           }
           if(pic=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please select a P.I.C.</b><br/>";
           }

           if(type=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please select a Type.</b><br/>";
           }
           if(title=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Title.</b><br/>";
           }

        }

        if(isallow)
          return true;
        else
          return false;
    }
</script>
<div id='blanket' style='display:none;'></div>
<div id='popUpDiv' style='display:none;verticle-align:center'>

     <div id='popupmessage' style='text-align:center'></div>
     <div id='progressimage' style='text-align:center'><img src='../simantz/images/ajax_indicator_01.gif'></div>
</div>

<div align="center">
<table style="width:700px;">
    <tr>
      <td style='text-align: center;' colspan='8' class="searchformheader">Follow Up Info</td>
    </tr>
<tr><td align="left" style="height:27px;">$addctrl</td></tr>

<tr><td align="center">

<ntb:grid id="DataboundGrid"
     mode="nonpaging"
     toolbarenabled='false'
     $permctrl
     onhtmlreadyevent="dataready()"
     singleclickeditenabled="true"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="bpartner.php?action=searchfollowup&bpartner_id=$this->bpartner_id"
     savehandler="bpartner.php?action=savefollowup&bpartner_id=$this->bpartner_id"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     onafterrowinsertevent="setDefaultValue(eventArgs)"
     rowhighlightenabled="true"
     width="943"
     height="200"
        rowheight="70"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes">

 <ntb:columns>

   <ntb:datecolumn classname="{\$rh}" label="Issue Date" width="65" xdatafld="issuedate" editable="true"  mask="yyyy-MM-dd"></ntb:datecolumn>

   <ntb:textcolumn classname="{\$rh}" label="Title" width="160" xdatafld="followup_name" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Type" width="95" xdatafld="followuptype_id" sortenabled="true">
              <ntb:lookupeditor delay="1000" gethandler="bpartner.php?action=getfollowuptype" displayfields="followuptype_name" valuefield="followuptype_id" ></ntb:lookupeditor>
        </ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="P.I.C" width="140" xdatafld="employee_id" sortenabled="true">
           <ntb:lookupeditor delay="1000" gethandler="bpartner.php?action=getemployeelist" displayfields="employee_name" valuefield="employee_id" ></ntb:lookupeditor>
       </ntb:textcolumn>

   <ntb:datecolumn classname="{\$rh}" label="Follow Up Date" width="90" xdatafld="nextfollowupdate" sortenabled="true"  mask="yyyy-MM-dd"></ntb:datecolumn>
   
   <ntb:textcolumn classname="{\$rh}" label="Contact Person" width="100" xdatafld="contactperson" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Contact No" width="65" xdatafld="contactnumber" sortenabled="true"></ntb:textcolumn>

   <ntb:textcolumn classname="{\$rh}" label="Description" width="200" xdatafld="description" ><ntb:textareaeditor></ntb:textareaeditor></ntb:textcolumn>
<ntb:textcolumn classname="{\$rh}" label="Active" width="60" xdatafld="isactive"  align="center">
     <ntb:checkboxeditor datasource="[{value:'1',display:''},{value:'0',display:''}]" checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value">
    </ntb:textcolumn>

EOF;
//only admin user will see record info and isdeleted column
if($isadmin==1)
{
echo<<< EOF
<ntb:textcolumn  label="Log"   xdatafld="info"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlog()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
EOF;
}
 echo <<< EOF
      <ntb:numbercolumn   label="ID"  width="0" xdatafld="followup_id" mask="###0" sortenabled="false">
                    </ntb:numbercolumn>
         <ntb:textcolumn  label="Del"   xdatafld=""    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebutton()">
            <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>
</ntb:columns>
</ntb:grid>

</td></tr>
<tr><td align="left">$savectrl</td></tr>
<tr><td align="left">
<input id='afterconfirm' value='0' type='hidden'>

<br> <div id="msgbox" class="blockContent"></div>
</td></tr></table></div>

EOF;
  }

    public function showFollowup($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_followup";

   $this->log->showLog(2,"Access showFollowup($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="issuedate, nextfollowupdate";
        }
        if(empty($sortdirection)){
           $sortdirection="DESC";
        }
     if($isadmin!=1)
        $wherestring.= " AND isdeleted=0";

     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("issuedate");
     	$getHandler->DefineField("followup_name");
     	$getHandler->DefineField("followuptype_id");
     	$getHandler->DefineField("bpartner_id");
        $getHandler->DefineField("isactive");
        $getHandler->DefineField("employee_id");
        $getHandler->DefineField("nextfollowupdate");
     	$getHandler->DefineField("contactperson");
        $getHandler->DefineField("contactnumber");
        $getHandler->DefineField("description");
        $getHandler->DefineField("info");
        $getHandler->DefineField("followup_id");
        $getHandler->DefineField("rh");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
                    $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {
          if($rh=="even")
            $rh="odd";
          else
            $rh="even";
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['followup_id']);
             $getHandler->DefineRecordFieldValue("issuedate", $row['issuedate']);
             $getHandler->DefineRecordFieldValue("followup_name", $row['followup_name']);
             $getHandler->DefineRecordFieldValue("followuptype_id",$row['followuptype_id']);
             $getHandler->DefineRecordFieldValue("bpartner_id", $row['bpartner_id']);
             $getHandler->DefineRecordFieldValue("employee_id", $row['employee_id']);
             $getHandler->DefineRecordFieldValue("nextfollowupdate",$row['nextfollowupdate']);
             $getHandler->DefineRecordFieldValue("contactperson",$row['contactperson']);
             $getHandler->DefineRecordFieldValue("contactnumber", $row['contactnumber']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("description", $row['description']);
             $getHandler->DefineRecordFieldValue("info","../simantz/recordinfo.php?id=".$row['followup_id']."&tablename=sim_followup&idname=followup_id&title=Follow Up");
             $getHandler->DefineRecordFieldValue("followup_id",$row['followup_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showFollowup()");
    }

    public function saveFollowup(){
        $this->log->showLog(3,"Access saveFollowup");
            include "../simantz/class/nitobi.xml.php";
            include_once "../simantz/class/Save_Data.inc.php";

            global $xoopsDB,$xoopsUser;
            $saveHandler = new EBASaveHandler();
            $saveHandler->ProcessRecords();
            $timestamp=date("Y-m-d H:i:s",time());
            $createdby=$xoopsUser->getVar('uid');
            $uname=$xoopsUser->getVar('uname');
            $uid=$xoopsUser->getVar('uid');


        $tablename="sim_followup";

            $save = new Save_Data();
            $insertCount = $saveHandler->ReturnInsertCount();
            $this->log->showLog(3,"Start Insert($insertCount records)");

    if ($insertCount > 0)
    {
          $arrfield=array("issuedate", "followup_name", "followuptype_id","employee_id",
                          "nextfollowupdate","contactperson","contactnumber","description",
                          "created","createdby","updated","updatedby","bpartner_id","isactive");
          $arrfieldtype=array('%s','%s','%d','%d',
                              '%s','%s','%s','%s',
                              '%s','%d','%s','%d','%d','%d');

    // Yes there are INSERTs to perform...
     for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
     {

         $arrvalue=array($saveHandler->ReturnInsertField($currentRecord,"issuedate"),
                    $saveHandler->ReturnInsertField($currentRecord,"followup_name"),
                    $saveHandler->ReturnInsertField($currentRecord,"followuptype_id"),
                    $saveHandler->ReturnInsertField($currentRecord,"employee_id"),
                    $saveHandler->ReturnInsertField($currentRecord,"nextfollowupdate"),
                    $saveHandler->ReturnInsertField($currentRecord,"contactperson"),
                    $saveHandler->ReturnInsertField($currentRecord,"contactnumber"),
                    $saveHandler->ReturnInsertField($currentRecord,"description"),
                    $timestamp,
                    $createdby,
                    $timestamp,
                    $createdby,
                    $this->bpartner_id,
             $saveHandler->ReturnInsertField($currentRecord,"isactive"));
         $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "followup_name");
         $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"followup_id");
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
      // Now we execute this query
     }
    }

    $updateCount = $saveHandler->ReturnUpdateCount();
    $this->log->showLog(3,"Start update($updateCount records)");

    if ($updateCount > 0)
    {
          $arrfield=array("issuedate", "followup_name", "followuptype_id","employee_id",
                          "nextfollowupdate","contactperson","contactnumber","description",
                          "updated","updatedby","isactive");
          $arrfieldtype=array('%s','%s','%d','%d',
                              '%s','%s','%s','%s',
                              '%s','%d','%d');
     // Yes there are UPDATEs to perform...

     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
             $this->log->showLog(3,"***updating record($currentRecord),new followup_name:".
                    $saveHandler->ReturnUpdateField($currentRecord, "followup_name").",id:".
                    $saveHandler->ReturnUpdateField($currentRecord, "followup_id")."\n");
             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "followup_name");

     }

     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
     {

         $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord,"issuedate"),
                    $saveHandler->ReturnUpdateField($currentRecord,"followup_name"),
                    $saveHandler->ReturnUpdateField($currentRecord,"followuptype_id"),
                    $saveHandler->ReturnUpdateField($currentRecord,"employee_id"),
                    $saveHandler->ReturnUpdateField($currentRecord,"nextfollowupdate"),
                    $saveHandler->ReturnUpdateField($currentRecord,"contactperson"),
                    $saveHandler->ReturnUpdateField($currentRecord,"contactnumber"),
                    $saveHandler->ReturnUpdateField($currentRecord,"description"),
                    $timestamp,
                    $createdby,$saveHandler->ReturnUpdateField($currentRecord,"isactive"));

            $this->log->showLog(3,"***updating record($currentRecord),new followup_name:".
                    $saveHandler->ReturnUpdateField($currentRecord, "followup_name").",id:".
                  $saveHandler->ReturnUpdateField($currentRecord,"followup_id")."\n");

             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "followup_name");

             $save->UpdateRecord($tablename, "followup_id", $saveHandler->ReturnUpdateField($currentRecord,"followup_id"),
                        $arrfield, $arrvalue, $arrfieldtype,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }

     }
    }

    $ispurge=0;
    $deleteCount = $saveHandler->ReturnDeleteCount();
    $this->log->showLog(3,"Start delete/purge($deleteCount records)");
    //include "class/Country.inc.php";
    //$o = new Country();

    if ($deleteCount > 0){
      for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
        $record_id=$saveHandler->ReturnDeleteField($currentRecord);

       // $this->fetchPortfolioline($record_id);
        $controlvalue=$this->followup_name;
        $isdeleted=$this->isdeleted;

        $save->DeleteRecord("sim_followup","followup_id",$record_id,$controlvalue,1);
      }

      }

    if($this->failfeedback!="")
    $this->failfeedback="Warning!<br/>\n".$this->failfeedback;
    $saveHandler->setErrorMessage($this->failfeedback);
    $saveHandler->CompleteSave();

    }

    public function fetchFollowup($followup_id){
	$this->log->showLog(3,"Fetching followup detail into class BPartner.php.<br>");

	$sql="SELECT * from sim_followup where followup_id=$followup_id";

	$this->log->showLog(4,"ProductFollowup->fetchFollowup, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->followup_name=$row["followup_name"];

   	$this->log->showLog(4,"ProductFollowup->fetchFollowup,database fetch into class successfully");
	$this->log->showLog(4,"followup_name:$this->followup_name");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"ProductFollowup->fetchFollowup,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  }
  // end of member function fetchPortfolioline





  public function getFormButton($btnname,$actionname,$para_val=array(),$method="POST"){
  //array("action"=>"personal","mode"=>"search");

      $btnhtml = "";

      $btnhtml .= "<form action='$actionname' method='$method'>";

      foreach($para_val as $leftvalue=>$rightvalue){
      $btnhtml .= "<input type='hidden' name = '$leftvalue' value= '$rightvalue' >";
      }

      $btnhtml .= "<input type='submit' value='$btnname'>";

      $btnhtml .= "</form>";

      return $btnhtml;
  }

  public function FetchNextEmployee($next){
    global $havewriteperm;
     if($next=="next"){
      $wherestring="employee_id > $this->employee_id order by employee_id asc";
     }
     else if($next=="previous"){
       $wherestring="employee_id < $this->employee_id order by employee_id desc";
     }
      $sql="Select employee_id from sim_hr_employee where  $wherestring LIMIT 0 , 1";
      $this->log->showLog(2,"Run FetchNextEmployee : $sql");
      $query=$this->xoopsDB->query($sql);
      while ($row=$this->xoopsDB->fetchArray($query)){
		$employee_id=$row['employee_id'];
      }
      return $employee_id;
  }

  public function showTabList(){
  global $bpartnertab,$bpartneridonly,$havewriteperm, $isadmin;

    //$this->fetchPersonalData();
   // $next_id=$this->FetchNextEmployee ('next');
    //$previous_id=$this->FetchNextEmployee ('previous');
   // $summary_button = $this->getFormButton("View Summary","employee.php",array("action"=>"viewsummary","employee_id"=>"$this->employee_id") );
   $search_button = $this->getFormButton("Search","bpartner.php",array("action"=>"search") );
   $new_button = $this->getFormButton("New","bpartner.php");

  if($isadmin==1){
    $delete_button = "<form action='bpartner.php' method='post' onsubmit='return confirmdelete()'>
                        <input type='hidden' name = 'action' value= 'bpartnerinfo'>
                        <input type='hidden' name = 'mode' value= 'delete'>
                        <input type='hidden' name = 'bpartner_id' value= $this->bpartner_id>
                        <input type='submit' value='Delete'>
                     </form>";
    if($next_id!="" && $next_id!="")
    $next_button = $this->getFormButton("Next bpartner","bpartner.php",array("action"=>"tablist","mode"=>"view","employee_id"=>$next_id));
    else
    $next_button ="";

    if($previous_id!="" && $previous_id!="")
    $previous_button = $this->getFormButton("Previous Employee","bpartner.php",array("action"=>"tablist","mode"=>"view","employee_id"=>$previous_id));
    else
    $previous_button="";
  }
  else{
    $delete_button="";
    $next_button = "";
    $previous_button="";
  }
    echo $this->searchAToZforDetail();
    if($this->isactive==1)
            $isactive=YES;
    elseif($this->isative==0)
            $isactive=NO;


echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){

                try {
                nitobi.loadComponent("tabstrip1")
                }
                catch(err) {
                }

		//dp.SyntaxHighlighter.ClipboardSwf = '/flash/clipboard.swf';
		//dp.SyntaxHighlighter.HighlightAll('code');


    }));

    function init(){}
    function confirmdelete(){
    if(confirm('Delete this Business Partner record?')){
    return true;
    }
    else
    return false;
    }

</script><br>
        <table>
            <tr>
            <td width="60px">$search_button</td>
            <td>$new_button</td>
            <td>$summary_button</td>
            <td><input style="display:none" type="button" name="vbutton" value="Print Business Partner Profile Cover" onclick="window.open('employeeprofile.php?employee_id=$this->employee_id')"></td>
            <td width="70%"></td>
            <td align="right">$previous_button</td>
            <td align="right">$next_button</td>
            </tr>
        </table>

        <table style="width:100%">
        <tr><td align="center" class="searchformheader">Business Partner Details</td></tr>
        <tr><td>
            <table class="searchformblock">
                <tr>
                    <td width="20%">Business Partner Name</td><td width="20%" id="bpartner_name">: <a href='../bpartner/bpartner.php?action=viewsummary&bpartner_id=$this->bpartner_id'>$this->bpartner_name</a></td>
                    <td width="20%">Business Partner No</td><td width="20%" id="bpartner_no" >: $this->bpartner_no</td>
                    <td width="10%">Active</td><td width="20%" id="isactive" >: $isactive</td>
                </tr>
                <tr>
                    <td>Business Partner Group</td><td id="bpartnergroup_name" >: $this->bpartnergroup_name</td>
                    <td>Industry</td><td id="industry_name" >: $this->industry_name</td>
                </tr>
            </table>
        </td></tr>

        <tr><td align="right" >$delete_button</td></tr>

        <tr height="10px"><td>
        </td></tr>

        <tr><td>
        <ntb:tabstrip id="tabstrip1" width="100%" height="680px" theme="nitobi">
                <ntb:tabs height="" align="left" overlap="15">

                        <ntb:tab width="200px" tooltip="Business Partner Info" label="Business Partner Info" source="bpartner.php?action=bpartnerinfo&$bpartnertab" containertype="iframe" ></ntb:tab>
                        <ntb:tab width="100px" loadondemandenabled="true" tooltip="Address" label="Address" source="bpartner.php?action=address&$bpartneridonly" containertype="iframe" ></ntb:tab>
                        <ntb:tab width="100px" loadondemandenabled="true" tooltip="Contact" label="Contact" source="bpartner.php?action=contact&$bpartneridonly" containertype="iframe" ></ntb:tab>
                        <ntb:tab width="120px" loadondemandenabled="true" tooltip="Follow up" label="Follow up" source="bpartner.php?action=followup&$bpartneridonly" containertype="iframe" ></ntb:tab>
                   </ntb:tabs>
        </ntb:tabstrip>
        </td></tr>

        </table>

EOF;

  }

  public function getIncludeFileMenu(){
      global $xoTheme;


    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/paginator.js");
    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/paginator.css");

    $xoTheme->addScript("$url/modules/simantz/include/validatetext.js");
    $xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
    $xoTheme->addScript("$url/modules/simantz/include/popup.js");
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.toolkit.js");
    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css");
    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.tabstrip/nitobi.tabstrip.css");
    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js");
    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.tabstrip/nitobi.tabstrip.js");
    $xoTheme->addScript("$url/modules/simantz/include/firefox3_6fix.js");

    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.js");
    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.css");
  }

  public function getSelectFollowuptype($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectFollowuptype()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$defaultorganization_id, $defaultorganization_id;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="followuptype_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

       $wherestring.= "AND organization_id='$defaultorganization_id'";

       $sql = "SELECT * FROM sim_followuptype $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["followuptype_id"]);
                       $getHandler->DefineRecordFieldValue("followuptype_id", $row["followuptype_id"]);
                       $getHandler->DefineRecordFieldValue("followuptype_name", $row["followuptype_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  }

  public function getSelectBpartnerList($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectBpartnerList()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$defaultorganization_id;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="seqno, bpartner_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

        $wherestring.= "AND organization_id='$defaultorganization_id'";

       $sql = "SELECT * FROM sim_bpartner $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["bpartner_id"]);
                       $getHandler->DefineRecordFieldValue("bpartner_id", $row["bpartner_id"]);
                       $getHandler->DefineRecordFieldValue("bpartner_name", $row["bpartner_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  }

  public function getSelectEmployeeList($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectEmployeeList()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$defaultorganization_id;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="seqno, employee_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

       $wherestring.= "AND organization_id='$defaultorganization_id'";
       
       $sql = "SELECT * FROM sim_hr_employee $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["employee_id"]);
                       $getHandler->DefineRecordFieldValue("employee_id", $row["employee_id"]);
                       $getHandler->DefineRecordFieldValue("employee_name", $row["employee_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  }

    public function getSelectRaces($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectRaces()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$defaultorganization_id, $defaultorganization_id;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="seqno, races_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

       $wherestring.= " AND organization_id='$defaultorganization_id'";

       $sql = "SELECT * FROM sim_races $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
       
                       $getHandler->CreateNewRecord($row["races_id"]);
                       $getHandler->DefineRecordFieldValue("races_id", 0);
                       $getHandler->DefineRecordFieldValue("races_name", "-Select One-");
                       $getHandler->SaveRecord();
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["races_id"]);
                       $getHandler->DefineRecordFieldValue("races_id", $row["races_id"]);
                       $getHandler->DefineRecordFieldValue("races_name", $row["races_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  }

    public function getSelectReligion($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectReligion()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$defaultorganization_id, $defaultorganization_id;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="seqno, religion_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

       $wherestring.= " AND organization_id='$defaultorganization_id'";

       $sql = "SELECT * FROM sim_religion $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
                       $getHandler->CreateNewRecord($row["religion_id"]);
                       $getHandler->DefineRecordFieldValue("religion_id", 0);
                       $getHandler->DefineRecordFieldValue("religion_name", "-Select One-");
                       $getHandler->SaveRecord();
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["religion_id"]);
                       $getHandler->DefineRecordFieldValue("religion_id", $row["religion_id"]);
                       $getHandler->DefineRecordFieldValue("religion_name", $row["religion_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  }

    public function getSelectAddress($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectAddress()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$defaultorganization_id, $defaultorganization_id;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="seqno, address_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

       $wherestring.= " AND organization_id='$defaultorganization_id'";

       $sql = "SELECT * FROM sim_address $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

                       $getHandler->CreateNewRecord($row["address_id"]);
                       $getHandler->DefineRecordFieldValue("address_id", 0);
                       $getHandler->DefineRecordFieldValue("address_name", "-Select One-");
                       $getHandler->SaveRecord();
                       
       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["address_id"]);
                       $getHandler->DefineRecordFieldValue("address_id", $row["address_id"]);
                       $getHandler->DefineRecordFieldValue("address_name", $row["address_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }

  }

  public function getSelectCountry($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectCountry()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$defaultorganization_id, $defaultorganization_id;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="seqno, country_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

       $wherestring.= " AND organization_id='$defaultorganization_id'";

       $sql = "SELECT * FROM sim_country $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["country_id"]);
                       $getHandler->DefineRecordFieldValue("country_id", $row["country_id"]);
                       $getHandler->DefineRecordFieldValue("country_name", $row["country_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }

  }

  public function getSelectRegion($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectRegion()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$defaultorganization_id, $defaultorganization_id;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="seqno, region_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

       $wherestring.= " AND organization_id='$defaultorganization_id'";

       $sql = "SELECT * FROM sim_region $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["region_id"]);
                       $getHandler->DefineRecordFieldValue("region_id", $row["region_id"]);
                       $getHandler->DefineRecordFieldValue("region_name", $row["region_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }

  }


} // end of ClassBPartner
?>

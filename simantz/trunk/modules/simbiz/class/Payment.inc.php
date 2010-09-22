<?php

class Payment{
    public $payment_id;
    public $document_no;
    public $organization_id;
    public $documenttype;
    public $document_date;
    public $batch_id;
    public $currency_id;
    public $exchangerate;
    public $subtotal;
    public $created;
    public $createdby;
    public $updated;
    public $updatedby;
    public $orgctrl;
    public $itemqty;
    public $ref_no;
    public $description;
    public $bpartner_id;
    public $iscomplete;
    public $bpartneraccounts_id;
    public $sppayment_prefix;
    public $issotrx;
    public $terms_id;
    public $contacts_id;
    public $preparedbyuid;
    public $salesagentname;
    public $isprinted;
    public $localamt;
    public $address_text;
    public $branch_id;
    public $track1_id;
    public $track2_id;
    public $track3_id;
    public $paymentfilename;
    public $gridfieldarray;
    public $gridfielddisplayarray;
    public $gridfieldwidtharray;
    public $gridfieldsortablearray;
    public $gridfieldtypearray;
    public $gridfieldstructure;
    public $gridfieldtype;
    public $gridvaluearray;
    public $gridfielddefault;
    private $xoopsDB;
    private $tablepayment;
    private $tablename;
    private $tablecurrency;
    private $log;

  
   public function Payment(){
	global $xoopsDB,$log,$tablepayment,$tablepaymentline,$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
        $this->organization_id=$defaultorganization_id;
	$this->log=$log;
        $this->tableorganization=$tableorganization;
	$this->tablecurrency=$tablecurrency;
	$this->tablepayment=$tablepayment;
        $this->tablepaymentline=$tablepaymentline;
        $this->tablename=$tablepayment;
        $this->log->showLog(3,"Access Payment()");
   
   }
    public function viewInputForm(){
    $grid=$this->getGrid($this->payment_id,"N");
    $this->address_text= str_replace("\n", "<br/>", $this->address_text);
    $this->address_text= str_replace(" ", "&nbsp;", $this->address_text);
    $this->description= str_replace("\n", "<br/>", $this->description);
    $this->description= str_replace(" ", "&nbsp;", $this->description);
    if($this->issotrx==1){
        $type="D";
    }
    else{$type="C";
    }
    
   include "../simbiz/class/Accounts.php";
     $acc = new Accounts();
     $creditstatusarr=$acc->getBPartnerCreditStatus($this->bpartneraccounts_id,$this->bpartner_id,$type);
      $consumecredit=$creditstatusarr[0];
     $creditlimit=$creditstatusarr[1];
     $enforcement=$creditstatusarr[2];
     if($consumecredit>=$creditlimit)
        $credittext="<b style='color:red;'>$creditlimit/$consumecredit</b>";
     else
        $credittext="$creditlimit/$consumecredit";
 $html =<<< HTML

    <br/>
    
    <div id='centercontainer'>
    <div align="center" >
    <table style="width:990px;text-align: left; " >
        <tr><td align="left">$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr></table>

         $noperm


    <br/>
    <div id='errormsg' class='red' style='display:none'></div>

<form onsubmit='return false' method='post' name='frmPayment' id='frmPayment'  action='$this->paymentfilename'  enctype="multipart/form-data">
   <table style="text-align: left; width: 990px;" border="0" cellpadding="0" cellspacing="1"  class="searchformblock">
    <tbody>
        <tr>
        <td colspan="5" rowspan="1" align="center" id="idHeaderText" class="searchformheader" >Payment</td>
        </tr>
        <tr>
          <td class="head">Payment No</td>
          <td class="even">$this->sppayment_prefix $this->document_no   Branch: $this->organization_code</td>
          <td class="head">Business Partner</td>
          <td class="even">
                <a href="../bpartner/bpartner.php?action=viewsummary&bpartner_id=$this->bpartner_id" target="_blank">$this->bpartner_name</a>
          </td>
         <td rowspan='6'><div class="searchformblock">
                    <b>Additional info</b><br/>
         <small>
            <a href="batch.php?action=edit&batch_id=$this->batch_id" target="_blank">View Journal</a><br/>
            <a href="">Print Statement</a><br/>
            C.Limit/Actual: $credittext <br/>
         </small>
         </div>
            </td>
     </tr>
     <tr>
        <td class="head">Date (YYYY-MM-DD)</td>
          <td class="even">$this->document_date
          <td class="head">Attn To </td>
          <td class="even">$this->contacts_name</td>
     </tr>
     <tr>
      <td class="head">Terms</td>
      <td class="even">$this->terms_name</td>
      <td class="head">Ref. No</td>
      <td class="even">$this->ref_no</td>
     </tr>
     <tr>
         <td class="head">Prepared By</td>
         <td class="even">$this->preparedbyname</td>
        <td class="head">Sales Agent</td>
         <td class="even">$this->salesagentname</td>
</tr>
<tr>
       <td class="head">Address</td>
       <td class="even">$this->address_text
        </td>
         <td class="head">Currency</td>
          <td class="even">Exchange rate: $this->currency_code Exchange Rate: $this->exchangerate</td>
  <tr>
    <td class="head">
              </td>

                 <td class="head">
        <input name='save' onclick='reactivatePayment()' type='submit' id='submit' value='Re-activate'>
          <input type="button" value="Reload" onclick=javascript:reloadPayment()>
            <input type="button" value="Preview" onclick=javascript:previewPayment()>
        <input name='payment_id' id='payment_id'  value='$this->payment_id'  title='payment_id' type='hidden'>
        <input name='iscomplete'  id='iscomplete' value='$this->iscomplete'  title='iscomplete' type='hidden'>
            </td>
</td></tr>
<tr><td colspan='5'>
    <div id='detaildiv'>
    $grid
           <div style="width:490px;text-align:right" >
            Total: $this->subtotal<br/>
            <b style="text-align:right; height:30px; border-top: 1px solid #000; border-bottom: 3px double #000; width:300px">
            Outstanding : $this->outstandingamt
           </b>
            </div>
</div>
</td></tr>
 <td class="head">Description</td>
<td class="even" colspan='3'>$this->description</td>
         <td rowspan="2"><br/><b>Tracking information</b>
            <div class="searchformblock" id="trackblock">
            $this->track1_name: $this->t1tname<br/>
            $this->track2_name: $this->t2tname<br/>
            $this->track3_name: $this->t3tname<br/>
            </div></td>
</tr><tr>
   <td class="head">Note</td>
<td class="even" colspan='3'>$this->note</td>
</tr></table>
</form>




HTML;
    return $html;
    }
    public function getInputForm($action="new"){

    global $userid,$simbizctrl,$ctrl,$defaultorganization_id;
    $this->log->showLog(3,"Access Payment getInputForm()");
       if($o->track1_id=="")
                $o->track1_id=0;
       if($o->track2_id=="")
               $o->track2_id=0;
       if($o->track3_id=="")
               $o->track3_id=0;

    $track1option=$simbizctrl->getSelectTrack($this->track1_id,"Y"," AND trackheader_id =1");
    $track2option=$simbizctrl->getSelectTrack($this->track2_id,"Y"," AND trackheader_id =2");
    $track3option=$simbizctrl->getSelectTrack($this->track3_id,"Y"," AND trackheader_id =3");
    
    if($action=="new"){
        include "../simbiz/class/Track.inc.php";
        $track = new Trackclass();
        $track_array = $track->getTrackName();
        $this->track1_name = $track_array['track1_name'];
        $this->track2_name = $track_array['track2_name'];
        $this->track3_name = $track_array['track3_name'];
        $this->bpartneraccounts_id=0;
        $tableheader="New Payment";
         $attnoption="<option value='0'>Null</option>";
        $uidoption= $ctrl->getSelectUsers($userid);
        $termsoption="<option value='0'>Null</option>";
        $addressoption="<option value='0'>Null</option>";
        $currencyoption="<option value='0'>Null</option>";
        $branchctrl=$ctrl->selectionOrganization($userid, $defaultorganization_id);
        $this->payment_id=0;
        $this->document_no=$this->getNextNo();
        $this->document_date=date("Y-m-d",time());
        $this->exchangerate=1;
        $this->subtotal=0;
        $this->localamt=0;
    }
    else{
        $tableheader="Edit Payment";
         include_once "../simantz/class/SelectCtrl.inc.php";
    $ctrl= new SelectCtrl();
    include "../bpartner/class/BPSelectCtrl.inc.php";
    $bpctrl = new BPSelectCtrl();
    include "../bpartner/class/BPartner.php";
    $bp = new BPartner();
    $bpartner_id=$_REQUEST['bpartner_id'];
    $bp->fetchBpartnerData($bpartner_id);

    $addressxml= $bpctrl->getSelectAddress($this->address_id,"N",$o->bpartner_id);
    $termsxml=  $bpctrl->getSelectTerms($this->terms_id,"N");
    $contactxml= $bpctrl->getSelectContacts($this->contacts_id,'N',"",""," and bpartner_id=$this->bpartner_id");
    $currencyxml=  $ctrl->getSelectCurrency($this->currency_id);

    $branchctrl=$ctrl->selectionOrganization($userid, $this->organization_id);



         $attnoption=$contactxml;
    $uidoption=$ctrl->getSelectUsers($this->preparedbyuid);
    $termsoption=$termsxml;
    $addressoption=$addressxml;
    $currencyoption=$currencyxml;
   // $branchoption="<option value='1'>HQ</option>";

    
    }

$grid=$this->getGrid($this->payment_id);

    $html =<<< HTML
    <br/>
    <div id='centercontainer'>
    <div align="center" >
    <table style="width:990px;text-align: left; " >
        <tr><td align="left">$this->addnewctrl </td><td align="right">$this->searchctrl</td></tr></table>
$noperm

   
    <br/>
    <div id='errormsg' class='red' style='display:none'></div>
<form onsubmit='return false' method='post' name='frmPayment' id='frmPayment'  action='$this->paymentfilename'  enctype="multipart/form-data">
   <table style="text-align: left; width: 990px;" border="0" cellpadding="0" cellspacing="1"  class="searchformblock">
    <tbody>
        <tr>
        <td colspan="4" rowspan="1" align="center" id="idHeaderText" class="searchformheader" >$tableheader</td>
        </tr>
        <tr>
          <td class="head">Payment No</td>
          <td class="even"><input name='sppayment_prefix' id='sppayment_prefix' value='$this->sppayment_prefix'size='3'>
                            <input name='document_no' id='document_no'  value='$this->document_no' size='10'>
                    Branch <select id='organization_id' name='organization_id'>&nbsp; $branchctrl</select></td>
          <td class="head">Business Partner</td>
          <td class="even">
              <ntb:Combo id="cmbbpartner_id" Mode="classic" theme="$nitobicombothemes" InitialSearch="$this->bpartner_name" onselectevent="chooseBPartner();">
             <ntb:ComboTextBox Width="250px" DataFieldIndex=1 ></ntb:ComboTextBox>
             <ntb:ComboList Width="300px" Height="200px" DatasourceUrl="../simbiz/simbizlookup.php?action=searchbpartnercombo&showNull=Y" PageSize="25" >
             <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
             <ntb:ComboMenu icon="images/add.gif" OnClickEvent="window.open('../bpartner/bpartner.php')" text=" &nbsp;Add product...">
             </ntb:ComboList>
            </ntb:Combo>
          </td>
     </tr>
     <tr>
        <td class="head">Date (YYYY-MM-DD)</td>
          <td class="even">
            <input id='document_date' name='document_date'  size='10'  value='$this->document_date'>
            <input id='btnpaymentdate' type='button' class='btndate' onclick="$this->showCalendar" value="Date"></td>
          <td class="head">Attn To </td>
          <td class="even"><select id='contacts_id' name='contacts_id' >$attnoption</select></td>
     </tr>
     <tr>
   
      <td class="head">Ref. No</td>
      <td class="even"><input id='ref_no' size='10' name='ref_no' value='$this->ref_no'></td>
     </tr>
     <tr>
         <td class="head">Prepared By</td>
         <td class="even"><select id='preparedbyuid' name='preparedbyuid'>$uidoption</select></td>
        <td class="head">Sales Agent</td>
         <td class="even"><input id='salesagentname'  name='salesagentname' value='$this->salesagentname'></td>
</tr>
<tr>
       <td class="head">Address</td>
       <td class="even"><select id='address_id' name='address_id' onchange=updateAddressText()>$addressoption</select><br/>
        <textarea id='address_text' name='address_text' cols='30' rows='3'>$this->address_text</textarea>
        </td>
         <td class="head">Currency</td>
          <td class="even">
                    <select id='currency_id' name='currency_id' onchange=comparecurrency()>$currencyoption</select> Exchange rate: MYR<input size='8' id='exchangerate' onchange=updateCurrency() value="$this->exchangerate" name="exchangerate"><br/>
     </td>
  <tr>
                 <td class="head" colspan='4'>
        <input name='save' onclick='saverecord(0)' type='submit' id='submit' value='Save'>
        <input name='save' onclick='saverecord(1);' type='submit' id='submit' value='Complete'>
        <input name='save' onclick='deleterecord()' type='submit' id='delete' value='Delete'>
        <input name='action' name='action' value='ajaxsave'  type="hidden">
        <input type="button" value="Reload" onclick=javascript:reloadPayment()>
        <input type="button" value="Receive All" onclick=javascript:receiveAll()>
            <input type="button" value="Preview" onclick=javascript:previewPayment()>
        <input name="track1_name" id="track1_name" type="hidden" value="$this->track1_name">
         <input name="track2_name" id="track2_name" type="hidden" value="$this->track2_name">
            <input name="track3_name"  id="track3_name" type="hidden" value="$this->track3_name">
        <input name='payment_id' id='payment_id'  value='$this->payment_id'  title='payment_id' type='hidden'>
        <input name='iscomplete'  id='iscomplete' value='$this->iscomplete'  title='iscomplete' type='hidden'>
        <input name='bpartneraccounts_id' id='bpartneraccounts_id' value='$this->bpartneraccounts_id' title='bpartneraccounts_id' type='hidden'>
            </td>
</td></tr>
<tr><td colspan='4'>
    <div id='detaildiv'>
    $grid
              <small>* Update payment detail via edit column Account, Paid Amt and following column, leave Paid Amt = 0 to delete particular payment detail</small>

           <div style="width:476px;text-align:right" >
                        <b style="text-align:right; height:30px; border-top: 1px solid #000; border-bottom: 3px double #000; width:300px">
             Total: <label id='lblsubtotal'><input id='subtotal' style="text-align:right"  size="10" name='subtotal' readonly="readonly" value='$this->subtotal'></label></b><br/>
              Outstanding : <label id='lbltotalgst'><input id='outstandingamt' size="10" style="text-align:right"  name='outstandingamt' readonly="readonly" value='$this->outstandingamt'></label>
            </div>

</div>
</td></tr>
 <td class="head">Description</td>
<td class="even" colspan='2'><textarea cols='70' rows='3' id='description'  name='description'>$this->description</textarea></td>
            <td rowspan="2"><br/><b>Tracking information</b>
            <div class="searchformblock" id="trackblock">
            $this->track1_name: <select name="track1_id" id="track1_id">$track1option</select><br/>
            $this->track2_name: <select name="track2_id" id="track1_id">$track2option</select><br/>
            $this->track3_name: <select name="track3_id" id="track1_id">$track3option</select><br/>
            </div></td>
</tr><tr>
   <td class="head">Note</td>
<td class="even" colspan='2'><textarea cols='70' rows='3' id='note'  name='note'>$this->note</textarea></td>
</tr></table>
</form>


HTML;
    return $html;
   }


public function getGrid($payment_id=0,$showAll="Y"){
    global $permctrl, $readonlypermctrl,$windowsetting,$nitobigridthemes;
    $data="";
    $editable="";
    if($this->iscomplete==1){
            $permctrl=$readonlypermctrl ;
             $editable="editable=\"false\" ";
             $showdelete="visible=\"false\"";
    }
     
/*     onaftercelleditevent="getTotalAmountCell(eventArgs)"
     onbeforerowdeleteevent="setDefaultValue(eventArgs,'delete')"
     onafterrowinsertevent="setDefaultValue(eventArgs,'add')"

 * onbeforecelleditevent="checkAllowEdit(eventArgs)"
 */
   return $xml=<<< _XML_
   <ntb:grid id="paymentgrid"
          mode="livescrolling"
     toolbarenabled="false"
     $permctrl
     singleclickeditenabled="true"
     gethandler="$this->paymentfilename?action=searchpaymentline&payment_id=$this->payment_id&bpartner_id=$this->bpartner_id&showAll=$showAll"
     savehandler="$this->paymentfilename?action=savePaymentline&payment_id=$this->payment_id"
     rowheight="20"
     width="1160"
     height="90"
     onhtmlreadyevent="optimizegridview()"
     onaftersaveevent="savedone(eventArgs)"
     autosaveenabled="false"
     theme="$nitobigridthemes">

<ntb:columns>    
    
<ntb:textcolumn classname="{\$rh}" width="60" label="Invoice"  xdatafld="invoice_no" sortenabled="false" editable="false"></ntb:textcolumn>
    
    <ntb:textcolumn classname="{\$rh}" label="Date" width="60" xdatafld="invoice_date" editable="false" sortenabled="false" $editable></ntb:textcolumn>
    <ntb:textcolumn classname="{\$rh}" label="Terms" width="50" xdatafld="terms_name" editable="false" sortenabled="false" $editable></ntb:textcolumn>
    <ntb:numbercolumn classname="{\$rh}" label="I. Amount" mask="#0.00" width="70" editable="false" xdatafld="invoice_amt" sortenabled="false"></ntb:numbercolumn>
    <ntb:numbercolumn classname="{\$rh}" label="Total Due" mask="#0.00" width="70" editable="false" xdatafld="balanceamt" sortenabled="false"></ntb:numbercolumn>
    <ntb:textcolumn classname="{\$rh}" label="Account" width="100" xdatafld="accounts_id" sortenabled="false" $editable>
               <ntb:listboxeditor gethandler="simbizlookup.php?action=getaccountlistgrid" displayfields="accounts_name" valuefield="accounts_id" ></ntb:listboxeditor>
           </ntb:textcolumn>
    <ntb:numbercolumn classname="{\$rh}" label="Paid Amt" width="65" mask="#0.00" xdatafld="amt" $editable sortenabled="false" onaftercelleditevent="updateCurrentRow(eventArgs)"></ntb:numbercolumn>
           <ntb:textcolumn classname="{\$rh}" label="Cheque No" width="65"  xdatafld="chequeno" $editable sortenabled="false" ></ntb:textcolumn>
    <ntb:textcolumn classname="{\$rh}" label="Description"  width="150" xdatafld="description" sortenabled="false" $editable>
           <ntb:textareaeditor></ntb:textareaeditor>
           </ntb:textcolumn>
    <ntb:textcolumn classname="{\$rh}" width="50" label="Branch"  xdatafld="branch_id" sortenabled="false" $editable>
           <ntb:listboxeditor gethandler="simbizlookup.php?action=getbranchlistgrid" displayfields="organization_code" valuefield="organization_id"></ntb:listboxeditor>
           </ntb:textcolumn>
    <ntb:textcolumn classname="{\$rh}"  width="50" $editable label="$this->track1_name"  xdatafld="track1_id" sortenabled="false">
           <ntb:listboxeditor gethandler="simbizlookup.php?action=gettracklist1grid" displayfields="track_name" valuefield="track_id" ></ntb:listboxeditor>
           </ntb:textcolumn>
    <ntb:textcolumn classname="{\$rh}"  width="50" $editable label="$this->track2_name"  xdatafld="track2_id" sortenabled="false">
           <ntb:listboxeditor gethandler="simbizlookup.php?action=gettracklist2grid" displayfields="track_name" valuefield="track_id" ></ntb:listboxeditor>
           </ntb:textcolumn>
    <ntb:textcolumn classname="{\$rh}"  width="50" $editable label="$this->track3_name"  xdatafld="track3_id" sortenabled="false">
        <ntb:listboxeditor gethandler="simbizlookup.php?action=gettracklist3grid" displayfields="track_name" valuefield="track_id" ></ntb:listboxeditor>
        </ntb:textcolumn>
      <ntb:textcolumn  label="Log" classname="{\$rh}"  xdatafld="info"   width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlog()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
<ntb:textcolumn classname="{\$rh}" label="PM"  visible="true"   xdatafld="payment_id" sortenabled="false"></ntb:textcolumn>
    <ntb:textcolumn classname="{\$rh}" label="ID"  width="30" visible="true" xdatafld="paymentline_id" editable="false"></ntb:textcolumn>
    <ntb:textcolumn classname="{\$rh}" width="170px" visible="true" label="Invoice"  xdatafld="invoice_id" sortenabled="false" $editable></ntb:textcolumn>
  </ntb:columns>
</ntb:grid>


_XML_;

}

public function showPaymentline($wherestring){
      include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$xoopsUser,$isadmin,$url;

   $tablename="sim_simbiz_paymentline";
   $this->log->showLog(2,"Access showPaymentline($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        $orderbystring="paymentline_id";
      
        $subsql="select sum(pl1.amt) from sim_simbiz_paymentline pl1 ".
            "inner join sim_simbiz_payment p1 on pl1.payment_id=p1.payment_id ".
            " where pl1.invoice_id=i.invoice_id and pl1.payment_id<>$this->payment_id and p1.iscomplete=1";
$bpartner_id=$_REQUEST['bpartner_id'];
//    if($this->payment_id>0 && $_REQUEST["showAll"] =="N") //complete mode
//       $wherestring=" AND pl.payment_id=$this->payment_id ";
//    elseif($this->payment_id==0) // new mode
//        $wherestring=" AND (pl.paymentline_id =0 OR) ";
//    elseif($this->payment_id>0 && $_REQUEST["showAll"] =="Y") //edit mode
//        $wherestring=" AND (pl.payment_id=$this->payment_id or 1)";

        $wherestring=" WHERE i.issotrx=$this->issotrx and i.bpartner_id=".$_REQUEST['bpartner_id']. " $wherestring";

          $sql1 ="SELECT i.invoice_id,concat(i.spinvoice_prefix,i.document_no) as invoice_no,tm.terms_name,
                i.granttotalamt - COALESCE(($subsql),0) as balanceamt,i.document_date as invoice_date,i.granttotalamt as invoice_amt,
            COALESCE(pl.paymentline_id,0) as paymentline_id,pl.description,
            COALESCE(pl.accounts_id,0) as accounts_id,
            pl.branch_id,pl.track1_id,pl.track2_id,pl.track3_id,
            COALESCE(pl.amt,0) as amt,
            COALESCE(pl.payment_id,0) as payment_id, pl.chequeno 
            FROM sim_simbiz_invoice i left join $tablename pl  on i.invoice_id = pl.invoice_id 
            inner join sim_terms  tm on tm.terms_id=i.terms_id
            where pl.payment_id=$this->payment_id AND i.issotrx=$this->issotrx and i.bpartner_id=$bpartner_id ";

       
          if($this->payment_id==0)
             $sql2 ="SELECT i.invoice_id,concat(i.spinvoice_prefix,i.document_no) as invoice_no,tm.terms_name,
                i.granttotalamt - COALESCE(($subsql),0) as balanceamt,i.document_date as invoice_date,i.granttotalamt as invoice_amt,
                0 as paymentline_id,'' as description,
                0 as accounts_id,
           0 as branch_id, 0 as track1_id, 0 as track2_id, 0 as track3_id,
            0 as amt,
            0 as payment_id, '' as chequeno
            FROM sim_simbiz_invoice i
            inner join sim_terms  tm on tm.terms_id=i.terms_id
            where i.granttotalamt - COALESCE(($subsql),0) <>0  AND i.issotrx=$this->issotrx and i.bpartner_id=$bpartner_id";
         else
          $sql2 ="SELECT i.invoice_id,concat(i.spinvoice_prefix,i.document_no) as invoice_no,tm.terms_name,
                i.granttotalamt - COALESCE(($subsql),0) as balanceamt,i.document_date as invoice_date,i.granttotalamt as invoice_amt,
                0 as paymentline_id,'' as description,
                0 as accounts_id,
           0 as branch_id, 0 as track1_id, 0 as track2_id, 0 as track3_id,
            0 as amt,
            0 as payment_id, '' as chequeno
            FROM sim_simbiz_invoice i 
            inner join sim_terms  tm on tm.terms_id=i.terms_id
            where i.granttotalamt - COALESCE(($subsql),0) <>0  AND i.issotrx=$this->issotrx and i.bpartner_id=$bpartner_id and
                i.invoice_id not in (select invoice_id from sim_simbiz_paymentline where payment_id=$this->payment_id)";


         if($this->payment_id>0 && $_REQUEST["showAll"] =="N") //complete mode
            $sql ="SELECT a.* FROM ($sql1) a order by a.paymentline_id";
    elseif($this->payment_id==0) // new mode
            $sql ="SELECT a.* FROM ($sql2) a order by a.paymentline_id";
    elseif($this->payment_id>0 && $_REQUEST["showAll"] =="Y") //edit mode
            $sql ="SELECT a.* FROM ($sql1 UNION ALL $sql2) a order by a.paymentline_id";

      $this->log->showLog(4,"With SQL: $sql $sortdirection");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("recordno");
        $getHandler->DefineField("paymentline_id");
        $getHandler->DefineField("invoice_no");
        $getHandler->DefineField("invoice_date");
        $getHandler->DefineField("terms_name");
        $getHandler->DefineField("accounts_id");
        $getHandler->DefineField("invoice_amt");
        $getHandler->DefineField("balanceamt");
     	$getHandler->DefineField("invoice_id");
     	$getHandler->DefineField("description");
     	$getHandler->DefineField("chequeno");
        $getHandler->DefineField("tax_id");
        $getHandler->DefineField("branch_id");
        $getHandler->DefineField("track1_id");
        $getHandler->DefineField("rh");
        $getHandler->DefineField("track2_id");
        $getHandler->DefineField("track3_id");
        $getHandler->DefineField("amt");
        $getHandler->DefineField("payment_id");
        $getHandler->DefineField("imgadd");
        
	$currentRecord = 0; // This will assist us finding the ordinalStart position
        $rh="odd";
        $temp_parent_id = 0;
        $i=0;
               $url_addimg = "images/add_line.gif";
      while ($row=$xoopsDB->fetchArray($query))
     {
       $this->log->showLog(4,"ordinalstart:$ordinalStart,run row:". $i++);
     

             if($rh=="odd")
                    $rh="even";
             else
                    $rh="odd";
             
          
     	    $currentRecord = $currentRecord +1;
      //      if($currentRecord > $ordinalStart){

             $getHandler->CreateNewRecord($i);
             $getHandler->DefineRecordFieldValue("invoice_id",$row['invoice_id']);
             $getHandler->DefineRecordFieldValue("invoice_no", $row['invoice_no']);
             $getHandler->DefineRecordFieldValue("invoice_date", $row['invoice_date']);
             $getHandler->DefineRecordFieldValue("terms_name", $row['terms_name']);

             $getHandler->DefineRecordFieldValue("accounts_id", $row['accounts_id']);
             $getHandler->DefineRecordFieldValue("description", $row['description']);
             $getHandler->DefineRecordFieldValue("amt", $row['amt']);
             $getHandler->DefineRecordFieldValue("invoice_amt", $row['invoice_amt']);

             $getHandler->DefineRecordFieldValue("balanceamt", $row['balanceamt']);
             $getHandler->DefineRecordFieldValue("chequeno", $row['chequeno']);
             $getHandler->DefineRecordFieldValue("branch_id",$row['branch_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->DefineRecordFieldValue("track1_id",$row['track1_id']);
             $getHandler->DefineRecordFieldValue("track2_id",$row['track2_id']);
             $getHandler->DefineRecordFieldValue("track3_id",$row['track3_id']);
             $getHandler->DefineRecordFieldValue("amt",$row['amt']);
             
             $getHandler->DefineRecordFieldValue("payment_id",$row['payment_id']);
             $getHandler->DefineRecordFieldValue("paymentline_id", $row['paymentline_id']);
             $getHandler->DefineRecordFieldValue("imgadd",$url_addimg);
             $getHandler->DefineRecordFieldValue("info","../simantz/recordinfo.php?tablename=sim_simbiz_paymentline&idname=paymentline_id&title=Payment&id=".$row['paymentline_id']);

             $getHandler->SaveRecord();
       //      }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showPaymentline()");
}

public function showSearchGrid($wherestring){
      include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

   $tablename="sim_simbiz_payment";
   $this->log->showLog(2,"Access showSearchGrid($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

                $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
        if(empty($sortcolumn)){
           $sortcolumn="concat(i.sppayment_prefix,i.document_no)";

        }
        if(empty($sortdirection)){
           $sortdirection="DESC";
        }

        



      ////$sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $sql = "SELECT i.payment_id,  concat(i.sppayment_prefix,i.document_no) as payment_no, i.document_date, i.subtotal, i.iscomplete,  ".
                " bp.bpartner_id, bp.bpartner_no,bp.bpartner_name, c.currency_code, u.uname,o.organization_code ".
            " FROM sim_simbiz_payment i ".
              " left join sim_bpartner bp on i.bpartner_id=bp.bpartner_id ".
            " left join sim_currency c on c.currency_id=i.currency_id ".
            " left join sim_users u on u.uid=i.preparedbyuid ".
              " left join sim_organization o on o.organization_id=i.organization_id
                  where issotrx=$this->issotrx".

        " $wherestring ORDER BY $sortcolumn $sortdirection";

      $this->log->showLog(4,"With SQL: $sql $sortdirection");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("payment_id");
        $getHandler->DefineField("bpartner_id");
        $getHandler->DefineField("payment_no");
        $getHandler->DefineField("document_date");
     	$getHandler->DefineField("subtotal");
        $getHandler->DefineField("iscomplete");
     	$getHandler->DefineField("bpartner_no");
     	$getHandler->DefineField("bpartner_name");
        $getHandler->DefineField("currency_code");
        $getHandler->DefineField("uname");
        $getHandler->DefineField("organization_code");

	$currentRecord = 0; // This will assist us finding the ordinalStart position
        $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {


             if($rh=="odd")
                    $rh="even";
             else
                    $rh="odd";

         if($row['iscomplete']==1){
          $iscomplete="Y";
          $edit="view";
         }
         else{
             $edit="edit";
             $iscomplete="N";
         }

     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){

             $getHandler->CreateNewRecord($row['payment_id']);
             $getHandler->DefineRecordFieldValue("payment_id", $row['payment_id']);
             $getHandler->DefineRecordFieldValue("bpartner_id",$row['bpartner_id']);
             $getHandler->DefineRecordFieldValue("payment_no", $row['payment_no']);
             $getHandler->DefineRecordFieldValue("document_date", $row['document_date']);
             $getHandler->DefineRecordFieldValue("amt", $row['subtotal']);
             $getHandler->DefineRecordFieldValue("iscomplete",$iscomplete);
             $getHandler->DefineRecordFieldValue("bpartner_no",$row['bpartner_no']);
             $getHandler->DefineRecordFieldValue("bpartner_name", $row['bpartner_name']);
             $getHandler->DefineRecordFieldValue("currency_code", $row['currency_code']);
             $getHandler->DefineRecordFieldValue("organization_code",$row['organization_code']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->DefineRecordFieldValue("edit","$this->paymentfilename?action=$edit&payment_id=".$row['payment_id']);

             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showPaymentline()");
}

public function fetchPayment($payment_id){
     $this->log->showLog(3,"Access fetchPayment($payment_id)");
      $sql="SELECT i.*,concat(bp.bpartner_name,'(', bp.bpartner_no,')' ) as bpartner_name,o.organization_code,
           c.contacts_name, u.uname,t1.track_name as t1tname,t2.track_name as t2tname,t3.track_name as t3tname
                FROM $this->tablepayment i
                left join sim_bpartner bp on i.bpartner_id=bp.bpartner_id
                left join sim_organization o on o.organization_id=i.organization_id
                left join sim_users u on u.uid=i.preparedbyuid
                left join sim_contacts c on c.contacts_id=i.contacts_id
                left join sim_simbiz_track t1 on i.track1_id=t1.track_id
                left join sim_simbiz_track t2 on i.track2_id=t2.track_id
                left join sim_simbiz_track t3 on i.track3_id=t3.track_id

                where payment_id=$payment_id";
     $query=$this->xoopsDB->query($sql);
     while($row=$this->xoopsDB->fetchArray($query)){
         $this->payment_id=$payment_id;
         $this->document_no=htmlspecialchars($row['document_no']);
         $this->bpartner_name=$row['bpartner_name'];
         $this->organization_code=$row['organization_code'];
         $this->organization_id=$row['organization_id'];
         $this->documenttype=$row['documenttype'];
         $this->document_date=$row['document_date'];
         $this->batch_id=$row['batch_id'];
         $this->amt=$row['amt'];
         $this->currency_id=$row['currency_id'];
         $this->exchangerate=$row['exchangerate'];
         $this->subtotal=$row['subtotal'];
         $this->created=$row['created'];
         $this->createdby=$row['createdby'];
         $this->updated=$row['updated'];
         $this->updatedby=$row['updatedby'];
         $this->itemqty=$row['itemqty'];
         $this->preparedbyname=$row['uname'];
         $this->contacts_name=$row['contacts_name'];
         $this->terms_name=$row['terms_name'];
         $this->ref_no=$row['ref_no'];
         $this->description=$row['description'];
         $this->bpartner_id=$row['bpartner_id'];
         $this->iscomplete=$row['iscomplete'];
         $this->bpartneraccounts_id=$row['bpartneraccounts_id'];
         $this->sppayment_prefix=$row['sppayment_prefix'];
         $this->issotrx=$row['issotrx'];
         $this->terms_id=$row['terms_id'];
         $this->batch_id=$row['batch_id'];
         $this->contacts_id=$row['contacts_id'];
         $this->preparedbyuid=$row['preparedbyuid'];
         $this->salesagentname=htmlspecialchars($row['salesagentname']);
         $this->isprinted=$row['isprinted'];
         $this->localamt=$row['localamt'];
         $this->address_id=$row['address_id'];
         $this->address_text=htmlspecialchars($row['address_text']);
         $this->branch_id=$row['branch_id'];
         $this->exchangerate=$row['exchangerate'];
         $this->track1_name=$row['track1_name'];
         $this->track2_name=$row['track2_name'];
         $this->track3_name=$row['track3_name'];
         $this->track1_id=$row['track1_id'];
         $this->track2_id=$row['track2_id'];
         $this->track3_id=$row['track3_id'];
         $this->t1tname=$row['t1tname'];
         $this->t2tname=$row['t2tname'];
         $this->t3tname=$row['t3tname'];
         $this->outstandingamt=$row['outstandingamt'];

         $this->note=$row['note'];
         $this->log->showLog(4,"Fetch data successfully");

         return true;
     }
     $this->log->showLog(4,"Cannot fetch payment with SQL: $sql");
     return false;

 }
 public function insertPayment( ) {

     include include "../simantz/class/Save_Data.inc.php";;
    $save = new Save_Data();

    $arrInsertField=array(
    "document_no",
    "organization_id",
    "documenttype",
    "document_date",
    "batch_id",
    "currency_id",
    "exchangerate",
    "subtotal",
    "created",
    "createdby",
    "updated",
    "updatedby",
    "itemqty",
    "ref_no",
    "description",
    "bpartner_id",
    "bpartneraccounts_id",
    "sppayment_prefix",
    "issotrx",
    "contacts_id",
    "preparedbyuid",
    "salesagentname",
    "isprinted",
    "localamt",
    "address_text",
    "track1_name",
    "track2_name",
    "track3_name",
        "address_id","outstandingamt","note",
            "track1_id",
    "track2_id",
    "track3_id",);
    $arrInsertFieldType=array(
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%f",
    "%f",
    "%s",
    "%d",
    "%s",
    "%d",
    "%d",
    "%s",
    "%s",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%f",
    "%s",
    "%s",
    "%s",
    "%s",
    "%d",
        "%f",
        "%s",
            "%d",
    "%d",
    "%d");
    $arrvalue=array($this->document_no,
   $this->organization_id,
   $this->documenttype,
   $this->document_date,
   $this->batch_id,
   $this->currency_id,
   $this->exchangerate,
   $this->subtotal,
   $this->updated,
   $this->updatedby,
   $this->updated,
   $this->updatedby,
   $this->itemqty,
   $this->ref_no,
   $this->description,
   $this->bpartner_id,
   $this->bpartneraccounts_id,
   $this->sppayment_prefix,
   $this->issotrx,
   $this->contacts_id,
   $this->preparedbyuid,
   $this->salesagentname,
   $this->isprinted,
   $this->localamt,
   $this->address_text,
   $this->track1_name,
   $this->track2_name,
   $this->track3_name,
        $this->address_id,
        $this->outstandingamt,
        $this->note,
           $this->track1_id,
   $this->track2_id,
   $this->track3_id);
    if($save->InsertRecord($this->tablename,   $arrInsertField,
            $arrvalue,$arrInsertFieldType,$this->sppayment_prefix.$this->document_no,"payment_id")){
            $this->payment_id=$save->latestid;
            return true;
            }
    else
            return false;

  }


 public function updatePayment( ) {

     include include "../simantz/class/Save_Data.inc.php";;
    $save = new Save_Data();
    $arrUpdateField=array(
        "document_no",
    "document_date",
    "batch_id",
    "currency_id",
    "exchangerate",
    "subtotal",
    "updated",
    "updatedby",
    "itemqty",
    "ref_no",
    "description",
    "bpartner_id",
    "bpartneraccounts_id",
    "sppayment_prefix",
    "contacts_id",
    "preparedbyuid",
    "salesagentname",
    "isprinted",
    "localamt",
    "address_text",
    "track1_name",
    "track2_name",
    "track3_name",
        "address_id",
        "organization_id",
        "outstandingamt",
    "note",
            "track1_id",
    "track2_id",
    "track3_id");
    $arrUpdateFieldType=array(
        "%d",
    "%s",
    "%d",
    "%d",
    "%f",
    "%f",
    "%s",
    "%d",
    "%d",
    "%s",
    "%s",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%s",
    "%d",
    "%f",
    "%s",
    "%s",
    "%s",
    "%s",
        "%d",
        "%d",
        "%f",
        "%s",
            "%d",
    "%d",
    "%d");
    $arrvalue=array($this->document_no,
   $this->document_date,
   $this->batch_id,
   $this->currency_id,
   $this->exchangerate,
   $this->subtotal,
   $this->updated,
   $this->updatedby,
   $this->itemqty,
   $this->ref_no,
   $this->description,
   $this->bpartner_id,
   $this->bpartneraccounts_id,
   $this->sppayment_prefix,
   $this->contacts_id,
   $this->preparedbyuid,
   $this->salesagentname,
   $this->isprinted,
   $this->localamt,
   $this->address_text,
   $this->track1_name,
   $this->track2_name,
   $this->track3_name,
   $this->address_id,
        $this->organization_id,
        $this->outstandingamt,
        $this->note,
           $this->track1_id,
   $this->track2_id,
   $this->track3_id);

    if( $save->UpdateRecord($this->tablename, "payment_id",
                $this->payment_id,
                    $arrUpdateField, $arrvalue,  $arrUpdateFieldType,$this->sppayment_prefix.$this->document_no))
            return true;
    else
            return false;

  }

  public function deletePayment($payment_id){
include "../simantz/class/Save_Data.inc.php";
$save = new Save_Data();

   if($this->fetchAccounts($payment_id)){

    return $save->DeleteRecord($this->tablename,"$payment_id",$payment_id,$this->sppayment_prefix.$this->document_no,1);
   }
   else
       return false;

}

public function insertPaymentLine($currentRecord,$saveHandler){
     $this->log->showLog(3,"access insertPaymentLine($currentRecord)");
                 include_once "../simantz/class/Save_Data.inc.php";
            $save = new Save_Data();

         global $xoopsDB,$xoopsUser, $timestamp,$createdby,$uname,$uid;
              $tablename="sim_simbiz_paymentline";

         $arrInsertField=array(
                "description","accounts_id","tax_id", "branch_id", "track1_id", "track2_id", "track3_id",
                "amt", "payment_id", "invoice_id","chequeno","created","createdby","updated","updatedby");
              $arrInsertFieldType=array(
                 "%s", "%d", "%d","%d","%s","%s","%s","%f","%d","%d","%s","%s","%d","%s","%d");
    // Yes there are INSERTs to perform...
  

         $arrvalue=array(
             $saveHandler->ReturnUpdateField($currentRecord, "description"),
             $saveHandler->ReturnUpdateField($currentRecord, "accounts_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "tax_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "branch_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "track1_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "track2_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "track3_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "amt"),
             $saveHandler->ReturnUpdateField($currentRecord, "payment_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "invoice_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "chequeno"),
                    $timestamp,
                    $createdby,
                    $timestamp,
                    $createdby);

             $arra=print_r($arrvalue,true);
             $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "invoice_no");
             $this->log->showLog(4,"insertPaymentLine controlvalue:$controlvalue:, with array:$arra");


      
         $save->InsertRecord($tablename, $arrInsertField, $arrvalue, $arrInsertFieldType,$controlvalue,"paymentline_id");
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
      // Now we execute this query
     }

}
public function updatePaymentLine($currentRecord,$saveHandler){
                 include_once "../simantz/class/Save_Data.inc.php";
            $save = new Save_Data();

         global $xoopsDB,$xoopsUser, $timestamp,$createdby,$uname,$uid;

    $tablename="sim_simbiz_paymentline";
        $arrUpdateField=array("payment_id",
                "description", "accounts_id", "invoice_id",
                "tax_id","branch_id","track1_id", "track2_id", "track3_id", "amt","chequeno","updated","updatedby");
              $arrUpdateFieldType=array("%d","%s","%d","%d","%d","%d","%s","%s","%s","%f","%s","%s","%d");



            $arrvalue=array($this->payment_id,
             $saveHandler->ReturnUpdateField($currentRecord, "description"),
             $saveHandler->ReturnUpdateField($currentRecord, "accounts_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "invoice_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "tax_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "branch_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "track1_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "track2_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "track3_id"),
             $saveHandler->ReturnUpdateField($currentRecord, "amt"),
                $saveHandler->ReturnUpdateField($currentRecord, "chequeno"),
                    $timestamp,
                    $createdby);
            $this->log->showLog(3,"***updating record($currentRecord), paymentline:subject".
                    $saveHandler->ReturnUpdateField($currentRecord, "subject"));

             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "subject");

             $save->UpdateRecord($tablename, "paymentline_id", $saveHandler->ReturnUpdateField($currentRecord,"paymentline_id"),
                        $arrUpdateField, $arrvalue, $arrUpdateFieldType,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
}
public function deletePaymentLine($currentRecord,$saveHandler){
                include_once "../simantz/class/Save_Data.inc.php";
            $save = new Save_Data();

         global $xoopsDB,$xoopsUser, $timestamp,$createdby,$uname,$uid;
        $tablename="sim_simbiz_paymentline";
          $record_id=$saveHandler->ReturnUpdateField($currentRecord,"paymentline_id");
        $controlvalue=$saveHandler->ReturnUpdateField($currentRecord,"invoice_no");
        $this->log->showLog(3,"delete: $currentRecord,$record_id");

        $save->DeleteRecord("sim_simbiz_paymentline","paymentline_id",$record_id,$controlvalue,1);


}

public function savePaymentLine(){
        $this->log->showLog(3,"Access savePaymentLine");
            include "../simantz/class/nitobi.xml.php";

            global $xoopsDB,$xoopsUser;
            $saveHandler = new EBASaveHandler();
            $saveHandler->ProcessRecords();
            $timestamp=date("Y-m-d H:i:s",time());
            $createdby=$xoopsUser->getVar('uid');
            $uname=$xoopsUser->getVar('uname');
            $uid=$xoopsUser->getVar('uid');


        $tablename="sim_simbiz_paymentline";

    $updateCount = $saveHandler->ReturnUpdateCount();
    $this->log->showLog(3,"Start update($updateCount records)");
    if ($updateCount > 0)
    {
        for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
        {
                 $paymentline_id=$saveHandler->ReturnUpdateField($currentRecord, "paymentline_id");
                 $invoice_id=$saveHandler->ReturnUpdateField($currentRecord, "invoice_id");
                 $amt=$saveHandler->ReturnUpdateField($currentRecord, "amt");
                 $this->log->showLog(3,"update record($currentRecord): paymentline_id=$paymentline_id,invoice_id=$invoice_id,amt=$amt");

                  if($paymentline_id>0 && $amt==0)
                      $this->deletePaymentLine($currentRecord,$saveHandler);
                  elseif($paymentline_id>0 && $amt<>0)
                      $this->updatePaymentLine($currentRecord,$saveHandler);
                  elseif($paymentline_id==0 && $amt<>0)
                      $this->insertPaymentLine($currentRecord,$saveHandler);
                  

        }
     }
        
    

    $ispurge=0;
    $deleteCount = $saveHandler->ReturnDeleteCount();
    $this->log->showLog(3,"Start delete/purge($deleteCount records)");
    

    if ($deleteCount > 0){
    
      }

    if($this->failfeedback!="")
    $this->failfeedback="Warning!<br/>\n".$this->failfeedback;
    $saveHandler->setErrorMessage($this->failfeedback);
    $saveHandler->CompleteSave();

    }


public function getPaymentLineSubject($paymentline_id){

    $sql="select concat(subject,'(',i.sppayment_prefix,i.document_no,')')  as subject from sim_simbiz_paymentline il
            inner join sim_simbiz_payment i on il.payment_id=i.payment_id
        where il.paymentline_id=$paymentline_id";
    $this->log->showLog(3,"access getPaymentLineSubject($paymentline_id)");
    $this->log->showLog(4,"with sql: $sql");

    $query=$this->xoopsDB->query($sql);
    $row=$this->xoopsDB->fetchArray($query);
    return $row['subject'];
}

public function validateForm(){
    return true;
}


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

  
public function showSearchForm(){
global $nitobigridthemes,$url,$ctrl,$simbizctrl;
$rowsperpage = 20;
  $new_button = $this->getFormButton("Add New","$this->paymentfilename");
  $this->currencyctrl=$ctrl->getSelectCurrency(0,"Y");
  
  echo <<< EOF

  <script src="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.css">
  
      <script language="javascript" type="text/javascript">
        jQuery(document).ready((function (){nitobi.loadComponent('searchgrid');}));
        function viewpayment(){

   	var g= nitobi.getGrid('searchgrid');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
        window.open(cellObj,"");

    }

    function doubleclickbpartner(){
	var g= nitobi.getGrid('searchgrid');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, 8);
        window.open("../bpartner/bpartner.php?action=viewsummary&bpartner_id="+cellObj,"");

    }


     function search(){
        
        var grid = nitobi.getGrid("searchgrid");

        var searchpayment_no=document.getElementById("searchpayment_no").value;
        var searchbpartner_id=document.getElementById("searchbpartner_id").value;
        
        var datefrom =document.getElementById('datefrom').value;
        var dateto =document.getElementById('dateto').value;

        var searchcurrency_id =document.getElementById("searchcurrency_id").value;
        var iscompletesearch =document.getElementById("iscompletesearch").value;
  return false;
        var searchTxt = "";

        if(datefrom != "")
        searchTxt += "Date From : "+datefrom+"<br/>";
        if(dateto != "")
        searchTxt += "Date To : "+dateto+"<br/>";

        if(searchpayment_no != "")
        searchTxt += "Payment no : "+searchpayment_no+"<br/>";
        if(searchbpartner_id > 0)
        searchTxt += "BPartner : "+"xxxxx"+"<br/>";

        if(searchcurrency_id > 0){
           
            searchTxt += "Currency : "+searchcurrency_id+"<br/>";
        }
        if(iscompletesearch != ""){
            if(iscompletesearch == 1)
            iscompletesearchname = "Y";
            else
            iscompletesearchname = "N";
            searchTxt += "Is Complete : "+iscompletesearchname+"<br/>";
        }


	grid.getDataSource().setGetHandlerParameter('searchpayment_no',searchpayment_no);
	grid.getDataSource().setGetHandlerParameter('searchbpartner_id',searchbpartner_id);
  	grid.getDataSource().setGetHandlerParameter('datefrom',datefrom);
	grid.getDataSource().setGetHandlerParameter('dateto',dateto);

	grid.getDataSource().setGetHandlerParameter('searchcurrency_id',searchcurrency_id);
	grid.getDataSource().setGetHandlerParameter('iscompletesearch',iscompletesearch);

        document.getElementById('rightBox').innerHTML = searchTxt;
        //reload grid data

	grid.dataBind();
    Pager.First('DataboundGrid');

    }

  
    </script>
<table style="width:990px;" align="center">

 <tr><td>$search</td></tr>

 <tr>
  <td align="center" >
<div align="left">$new_button</div>
<div id='centercontainer' >

<form name="frmSearch" id="frmSearch" onsubmit="return search()">
<table>
 <tr><td></td></tr>
   <tr> <td colspan="7" class="searchformheader">Search Payment</td> </tr>

   <tr>
    <td class="searchformblock">

   <table >
    <tr>
      <td class="head">Payment No</td>
      <td class="even"><input type="text" $colstyle name="searchpayment_no" id="searchpayment_no" value="$this->searchpayment_no"/></td>
      <td class="head">Business Partner</td>
      <td class="even"><input type="text" $colstyle name="searchbpartner_id" id="searchbpartner_id" value=""/></td>
   </tr>
    <tr>
      <td class="head">Date From</td>
      <td class="even"><input type="text" $colstyle name="datefrom" id="datefrom" value="$this->datefrom" size="10"/>
                        <input name="" type="button" onclick="" value="Date"></td>
      <td class="head">Date To</td>
      <td class="even"><input type="text" $colstyle name="dateto" id="dateto" value="$this->dateto" size="10"/>
                        <input name="" type="button" onclick=""  value="Date"></td>
   </tr>
   <tr>
      <td class="head">Currency</td>
      <td class="even">
         <select name="searchcurrency_id" id="searchcurrency_id" $colstyle>
           $this->currencyctrl
         </select>
      </td>
      <td class="head">Is Active</td>
      <td class="even">
           <select $colstyle name="searchiscomplete" id="searchiscomplete">
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

<div align="center">

     <form name="frmPaymentListTable" action="$this->paymentfilename" method="POST" target="_blank" onsubmit='return validate()'>
     <input type="hidden"  name="action" id="action" value="">
     <input type="hidden" id="totalRowGrid" value="$rowsperpage">
<table style="width:700px;" class="searchformblock" >

 <tr >
    <td class="head tdPager" colspan="2" >
    <small>* Double click BPartner to view business partner</small>
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



    <ntb:grid id="searchgrid"
     mode="livescrolling"
     gethandler="$this->paymentfilename?action=ajaxsearch"
     theme="$nitobigridthemes"
     rowhighlightenabled="true"
     toolbarenabled="false"
     editable="false"
     width="970"
     height="255"
    >
   <ntb:columns>
       <ntb:textcolumn  classname="{\$rh}" width="40" label="Org"  xdatafld="organization_code"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="70" label="Payment No"  xdatafld="payment_no"  editable="false" ></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="200" label="BPartner"  xdatafld="bpartner_name"  oncelldblclickevent=javascript:doubleclickbpartner()></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="50" label="Currency"  xdatafld="currency_code"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="80" label="Amount"  xdatafld="amt"   editable="false" ></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="70" label="Complete"  xdatafld="iscomplete"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="40" label="Edit"  xdatafld="edit"  oncellclickevent="javascript:viewpayment()">
        <ntb:imageeditor imageurl="images/edit.gif"></ntb:imageeditor></ntb:textcolumn>
        <ntb:textcolumn  classname="{\$rh}" width="70" label="bpartner_id" visible="false" xdatafld="bpartner_id" ></ntb:textcolumn>
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
public function showSearchForm2(){
    global $nitobigridthemes;
  return  $xml=<<< _EOF

   <a href='$this->paymentfilename'>[Add Payment]</a>
<form onsubmit='return false'>
   <table>
        <tbody>
            <tr><th colspan='4'>Search Form</th></tr>
            <tr>
                <td>Payment No From</td>
                <td><input id='document_nofrom'></td>
                <td>Payment No To</td>
                <td><input id='document_noto'></td>
            </tr>
            </tbody>
   </table>
</form>
<br/>

    <ntb:grid id="searchgrid"
     mode="livescrolling" 
     gethandler="$this->paymentfilename?action=ajaxsearch"
     theme="$nitobigridthemes"
     rowhighlightenabled="true"
     toolbarenabled="false"
     editable="false"
    >
   <ntb:columns>
       <ntb:textcolumn  classname="{\$rh}" width="40" label="Org"  xdatafld="organization_code"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="70" label="Payment No"  xdatafld="payment_no"  editable="false" ></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="200" label="BPartner"  xdatafld="bpartner_name"  oncelldblclickevent=javascript:doubleclickbpartner()></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="80" label="Terms"  xdatafld="terms_name"   editable="false" ></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="50" label="Currency"  xdatafld="currency_code"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="80" label="Amount"  xdatafld="amt"   editable="false" ></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="70" label="Complete"  xdatafld="iscomplete"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="40" label="Edit"  xdatafld="edit"  oncellclickevent="javascript:viewpayment()">
        <ntb:imageeditor imageurl="images/edit.gif"></ntb:imageeditor></ntb:textcolumn>
        <ntb:textcolumn  classname="{\$rh}" width="70" label="bpartner_id" visible="false" xdatafld="bpartner_id" ></ntb:textcolumn>
 </ntb:grid>
_EOF;
}


public function gridjs(){
global $defaultcurrency_id;
  return  $js= <<< JS
      <script language="javascript" type="text/javascript">
        $(document).ready((function (){
        nitobi.loadComponent('paymentgrid');
        nitobi.loadComponent('cmbbpartner_id');
       
        }));



        function chooseBPartner(){
              var bpid=document.getElementById("cmbbpartner_idSelectedValue0").value;
                   var data="action="+"getbpartnerinfo"+
                            "&bpartner_id="+bpid;
                var grid = nitobi.getGrid('paymentgrid');
                    $.ajax({
                         url:"$this->paymentfilename",type: "POST",data: data,cache: false,
                             success: function (xml)
                             {
                           
                               var address=$(xml).find("address").text().replace(/{{{/g,"<").replace(/}}}/g,">");
                                var terms=$(xml).find("terms").text().replace(/{{{/g,"<").replace(/}}}/g,">");
                                 var contact=$(xml).find("contact").text().replace(/{{{/g,"<").replace(/}}}/g,">");
                                 var currency=$(xml).find("currency").text().replace(/{{{/g,"<").replace(/}}}/g,">");
                               var salesagent=$(xml).find("salesagent").text();
                               var bpartneraccounts_id=$(xml).find("bpartneraccounts_id").text();
                               grid.getDataSource().setGetHandlerParameter('bpartner_id',bpid);
                               grid.dataBind();
                                $("#address_id").html(address);
                                $("#contacts_id").html(contact);
                                $("#terms_id").html(terms);
                                $("#currency_id").html(currency);
                                document.getElementById("salesagentname").value=salesagent;
                                document.getElementById("bpartneraccounts_id").value=bpartneraccounts_id;

                                comparecurrency();
                                
                               updateAddressText();
                               
                             }
                           });

           

                }
        function comparecurrency(){
            if(document.getElementById("currency_id").value==$defaultcurrency_id)
               document.getElementById("exchangerate").value=1;
                else
                document.getElementById("exchangerate").value=0;

          updateCurrency();
          }
          
        function updateAddressText(){
            var checkaddresstext="action=checkaddresstext&address_id="+document.getElementById("address_id").value;
                                 $.ajax({url:"$this->paymentfilename",type: "POST",data: checkaddresstext,cache: false,
                                    success: function (ad){
                                        document.getElementById("address_text").value=ad;
                                        }
                                });
          }

        function addLine(){
          var myGrid = nitobi.getGrid('paymentgrid');
          var payment_id=document.getElementById('payment_id').value;
          myGrid.insertAfterCurrentRow();
          
          if(payment_id>0){

               total_row = myGrid.getRowCount();

                                    for( var i = 0; i < total_row; i++ ) {
                                        var celly = myGrid.getCellObject( i, 15);
                                        celly.setValue(payment_id);
                                    }
            }
        }
    function viewlog(){
   	var g= nitobi.getGrid('paymentgrid');
        var selRow = g.getSelectedRow();
              var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
      window.open(cellObj,"");
    }

        function deleteLine(){
        if(confirm('Delete this line? It will force save current record and delete current line.')){
        var myGrid = nitobi.getGrid('paymentgrid');
            myGrid.deleteCurrentRow();
            saverecord(0);
        }
        }


        function saverecord(iscomplete){
            var iscompletectrl=document.getElementById("iscomplete");
             iscompletectrl.value=iscomplete;
              updateCurrentRow();
                document.getElementById("popupmessage").innerHTML="Saving data...";
                popup('popUpDiv');
        
              var payment_id=document.getElementById("payment_id").value;
                var errordiv=document.getElementById("errormsg");
                errordiv.style.display="none";


                var data =$("#frmPayment").serialize();
              

            $.ajax({
                 url: "$this->paymentfilename",type: "POST",data: data,cache: false,
                     success: function (xml) {
         
                     var status=$(xml).find("status").text();
                 
                     if(status==1){
                    var grid= nitobi.getGrid('paymentgrid');

                       errordiv.style.display="none";
                         total_row = grid.getRowCount();
              
                              if(payment_id==0){
                                     var id=$(xml).find("payment_id").text() ;

                                    document.getElementById("payment_id").value=id;

                                    
                           
                                    for( var i = 0; i < total_row; i++ ) {
                                        var celly = grid.getCellObject( i, 14);
                                        celly.setValue(id);
                                    }

                                }
                                        if( grid.getDataSource().getChangeLogXmlDoc().selectNodes("//ntb:data/*").length != 0 )
                                            {
                                               grid.save();
                                            }
                                            else
                                            {if(iscomplete==1)
                                                posting();
                                            }
                                           
                                        

                        }
                    else if(status==0){

                                errordiv.style.display="";
                            errordiv.innerHTML="Cannot save record due to internal error"+xml;
                                      
                                           
                          
                     }
                     else if(status=-1){
                            errordiv.style.display="";
                            var fieldname="";
                            var msg="";
                             $(xml).find("field").each(function()
                                {
                                var id=$(this).attr("id");
                                 fieldname=$(this).find("fieldname").text();
                                  $("#"+fieldname).addClass('validatefail');
                                   msg=msg+$(this).find("msg").text()+"<br/>";

                                 });
                                 document.getElementById("errormsg").innerHTML=msg;
                    }
                     else
                     alert("unknown status");
                     document.getElementById("popupmessage").innerHTML=xml;

                    document.getElementById("popupmessage").innerHTML="Completed!";
                    popup('popUpDiv');
                }});

         

        }
        function reloadgrid(){
          var  grid = nitobi.getGrid('paymentgrid');
          grid.dataBind();

          }
         function deleterecord(){

          if(confirm('Delete this record?')){
           var payment_id=document.getElementById("payment_id").value;
            var data="action=ajaxdelete&payment_id="+payment_id;
            $.ajax({
                 url: "accounts.php",type: "POST",data: data,cache: false,
                     success: function (xml) {
                       alert("Record deleted, please proceed to add new record.");
                    }});
          }
        }

        function onclickcell(eventArgs){
          var  myGrid = nitobi.getGrid('paymentgrid');
          var  row = eventArgs.cell.getRow();
          var col = eventArgs.cell.getColumn();
          var myCell = myGrid.getCellObject(row, col);
          myCell.edit();
        }

        function updateCurrentRow(eventArgs){
            var  grid = nitobi.getGrid('paymentgrid');
          
              total_row = grid.getRowCount();
              var total=0;
                var outstandingtotal=0;
              for( var i = 0; i < total_row; i++ ) {
                    var amt = grid.getCellObject( i, 6);
                    var dueamt = grid.getCellObject( i, 4);
                    outstandingtotal=outstandingtotal+dueamt.getValue();
                    total=total+amt.getValue();
              }
              document.getElementById("subtotal").value=total.toFixed(2);
              
              document.getElementById("outstandingamt").value=outstandingtotal.toFixed(2)-total.toFixed(2);
      
          }

             function receiveAll(){
            var  grid = nitobi.getGrid('paymentgrid');

              total_row = grid.getRowCount();
              var total=0;
              for( var i = 0; i < total_row; i++ ) {
                    var dueamt = grid.getCellObject( i, 4).getValue();
                    var amt = grid.getCellObject( i, 6);
                    amt.setValue(dueamt);

                    total=total+amt.getValue();
              }
              document.getElementById("subtotal").value=total.toFixed(2);
                          document.getElementById("outstandingamt").value="0.00";

          }

        function optimizegridview(){
            var  grid = nitobi.getGrid('paymentgrid');
            total_row = grid.getRowCount();
            if(total_row==0)
                addLine();
            total_row = grid.getRowCount();
          //grid.resize(1260,total_row*20+30);
            grid.setHeight(total_row*20+30);

          }
          
          function updateCurrency(){

            document.getElementById("subtotal").value=document.getElementById("subtotal").value*document.getElementById("exchangerate").value;
          }
        function reloadPayment(){
          var action="edit";
          if(document.getElementById("iscomplete").value==1)
            action="view";
          
        if(document.getElementById("payment_id").value>0)
        window.location="$this->paymentfilename?action="+action+"&payment_id="+document.getElementById("payment_id").value;
        else
        window.location="$this->paymentfilename";
        }
          
        function previewPayment(){
                window.open("view$this->paymentfilename?payment_id="+document.getElementById("payment_id").value)

        }
        function savedone(even){
          var  grid = nitobi.getGrid('paymentgrid');
            grid.dataBind();
            if(document.getElementById("iscomplete").value==1){
                    posting();
          }
        }



          
    function reactivatePayment(){
          var payment_id=document.getElementById("payment_id").value;
           var data="action=reactivate&payment_id="+payment_id;
            $.ajax({
                        url: "$this->paymentfilename",type: "POST",data: data,cache: false,
                success: function (xml) {
                             if(xml != ""){
                             jsonObj = eval( '(' + xml + ')');

                                if(jsonObj.status==1){
                                document.getElementById("iscomplete").value=0;
                                reloadPayment();
                                }
                                else
                                alert("Cannot reactivate payment! Msg: "+jsonObj.msg);
                                }
                                }
                   });
          
          }
 
     function posting(){
   var data="action=posting&payment_id="+document.getElementById("payment_id").value;
            $.ajax({
                        url: "$this->paymentfilename",type: "POST",data: data,cache: false,
                        success: function (xml) {
                             if(xml != ""){
                                    jsonObj = eval( '(' + xml + ')');
                                    var status = jsonObj.status;
                                    if(status==1)
                                        reloadPayment();
                                    else
                                        alert("cannot post record, please check you financial year setting");
                              }
                          }

            });
    }
        </script>
    
JS;
}


  public function getNextNo() {

   $sql="SELECT MAX(document_no ) + 1 as newno from $this->tablepayment where issotrx=$this->issotrx";
	$this->log->showLog(3,"Checking next no: $sql");

	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$newno=$row['newno'];
		$this->log->showLog(3,"Found next newno:$newno");
		if($newno=="")
		return 1;
		else
		return  $newno;
	}
	else
	return 1;

  } // end


  public function defineHeaderButton(){
           global $action;

    $this->addnewctrl='<form action="'.$this->paymentfilename.'" ><input type="submit" value="Add New"></form>';
        if($action=="search"){
    $this->searchctrl='';
    }
    else
    $this->searchctrl='<form action="'.$this->paymentfilename.'?action=search" ><input type="hidden" name="action" value="search"><input type="submit" value="Search"></form>';
  }

  public function posting(){
    include "../simbiz/class/AccountsAPI.php";
        $multiply=1;

    if($this->issotrx==1)
        $multiply=-1;
       $acc = new AccountsAPI();
       global $defaultcurrency_id,$defaultorganization_id,$userid,$taxaccount_id,$xoopsUser;
     $documentnoarray=array($this->sppayment_prefix.$this->document_no);
     $totaltransactionamt=$this->subtotal;
     $accountsarray=array($this->bpartneraccounts_id);
     $amtarray=array($this->subtotal* $multiply);
     $currencyarray=array($defaultcurrency_id);
     $conversionarray=array(1);
     $originalamtarray=array($this->subtotal* $multiply);
     $bpartnerarray=array($this->bpartner_id);
    $linetypearray=array(0);

     $transtypearray=array("");
     
     $chequenoarray=array("");
     $linedesc=array($this->description);
    $orgarray=array($this->organization_id);
    $track1array=array($this->track1_id);
    $track2array=array($this->track2_id);
    $track3array=array($this->track3_id);
    $sql="SELECT pl.invoice_id,concat(i.spinvoice_prefix,i.document_no) as invoice_no,pl.chequeno,
        pl.amt,pl.branch_id,pl.track1_id,pl.track2_id,pl.track3_id,pl.accounts_id
        from sim_simbiz_paymentline pl
        inner join sim_simbiz_invoice i on pl.invoice_id=i.invoice_id
        where payment_id=$this->payment_id";
    $query=$this->xoopsDB->query($sql);
$this->log->showLog(4,"Posting payment with SQL:  $sql");


    //$taxaccount_id=
       //declare 2nd line and above as creditor
       while($row=$this->xoopsDB->fetchArray($query)){

        array_push($documentnoarray, $this->sppayment_prefix.$this->document_no);
        array_push($accountsarray,$row['accounts_id']);
        array_push($amtarray,$row['amt']*-1* $multiply);
        array_push($currencyarray,$defaultcurrency_id);
        array_push($conversionarray,1);
        array_push($originalamtarray,$row['amt']*-1* $multiply);
        array_push($bpartnerarray,0);
        array_push($linetypearray,1);
        array_push($transtypearray,"");
        array_push($chequenoarray,$row['chequeno']);
        array_push($linedesc,"Payment ($this->sppayment_prefix$this->document_no), from $this->bpartner_name");
        array_push($orgarray,$row['branch_id']);
        array_push($track1array,$row['track1_id']);
        array_push($track2array,$row['track2_id']);
        array_push($track3array,$row['track3_id']);
        

       }
                ;
//        $a=array($uid,
//            $this->document_date,
//            "simbiz",
//            "Payment: $this->sppayment_prefix$this->document_no",
//            $this->description,
//            $this->localamt,
//               $documentnoarray,
//		$accountsarray,
//            $amtarray,
//            $currencyarray,
//            $conversionarray,
//            $originalamtarray,
//            $bpartnerarray,
//            $transtypearray,
//            $linetypearray,
//		$chequenoarray,
//            "",
//            1,
//            "",
//            $orgarray,
//            $track1array,
//            $track2array,
//            $track3array);
        $uname=$xoopsUser->getVar('uname');
       if($acc->PostBatch($userid,$this->document_date,"simbiz","Payment $this->sppayment_prefix$this->document_no",
               "Post from Simbiz: Payment ($this->sppayment_prefix$this->document_no), from $uname",$this->subtotal,
               $documentnoarray,$accountsarray,$amtarray,$currencyarray,$conversionarray,$originalamtarray,$bpartnerarray,$transtypearray,$linetypearray,
		$chequenoarray,$linedesc,1,"",$orgarray, $track1array, $track2array,$track3array)){
                 $this->batch_id=$acc->resultbatch_id;
                 $this->xoopsDB->query("update sim_simbiz_payment set batch_id=$acc->resultbatch_id,iscomplete=1 where payment_id=$this->payment_id");
               return true;
                }
       else{
            
            return false;
       }
       }


}

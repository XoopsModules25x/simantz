<?php

class Quotation{
    public $quotation_id;
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
    
    public $spquotation_prefix;
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
    public $quotationfilename;
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
    private $tablequotation;
    private $tablename;
    private $tablecurrency;
    private $log;

  
   public function Quotation(){

	global $xoopsDB,$log,$tablequotation,$tablequotationline,$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
        $this->organization_id=$defaultorganization_id;
	$this->log=$log;
        $this->tableorganization=$tableorganization;
	$this->tablecurrency=$tablecurrency;
	$this->tablequotation=$tablequotation;
        $this->tablequotationline=$tablequotationline;
        $this->tablename="sim_bpartner_quotation";
        $this->log->showLog(3,"Access Quotation()");

        }

public function viewInputForm(){

    $grid=$this->getGrid($this->quotation_id);
    $this->address_text= str_replace("\n", "<br/>", $this->address_text);
    $this->address_text= str_replace("  ", " &nbsp;", $this->address_text);
    $this->description= str_replace("\n", "<br/>", $this->description);
    $this->description= str_replace("  ", " &nbsp;", $this->description);


          $startdate=date("Y-m-",time())."01";
     $enddate=date("Y-m-d",time());
 $html =<<< HTML
<div id="idApprovalWindows" style="display:none"></div>
<div id='blanket' style='display:none;'></div>

    <br/>
    
    <div id='centercontainer'>
    <div align="center" >
    <table style="width:990px;text-align: left; " >
        <tr><td align="left">$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr></table>

         $noperm


    <br/>
    <div id='errormsg' class='red' style='display:none'></div>

<form onsubmit='return false' method='post' name='frmQuotation' id='frmQuotation'  action='$this->quotationfilename'  enctype="multipart/form-data">
   <table style="text-align: left; width: 990px;" border="0" cellpadding="0" cellspacing="1"  class="searchformblock">
    <tbody>
        <tr>
        <td colspan="5" rowspan="1" align="center" id="idHeaderText" class="searchformheader" >Quotation</td>
        </tr>
        <tr>
          <td class="head">Quotation No</td>
          <td class="even">$this->spquotation_prefix $this->document_no   Branch: $this->organization_code</td>
          <td class="head">Business Partner</td>
          <td class="even">
                <a href="../bpartner/bpartner.php?action=viewsummary&bpartner_id=$this->bpartner_id" target="_blank">$this->bpartner_name</a>
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
        <input name='save' onclick='reactivateQuotation()' type='submit' id='submit' value='Re-activate'>
          <input type="button" value="Reload" onclick=javascript:reloadQuotation()>
            <input type="button" value="Preview" onclick=javascript:previewQuotation()>
            <input type="button" value="Duplicate" onclick=javascript:duplicateQuotation()>
        <input name='quotation_id' id='quotation_id'  value='$this->quotation_id'  title='quotation_id' type='hidden'>
        <input name='iscomplete'  id='iscomplete' value='$this->iscomplete'  title='iscomplete' type='hidden'>

            </td>
</td></tr>
<tr><td colspan='5'>
    <div id='detaildiv'>
    $grid
           <div style="width:895px;text-align:right" >
            Total: $this->subtotal<br/>
            
            </div>
</div>
</td></tr>
 <td class="head">Description</td>
<td class="even" colspan='4' style="width:70%">$this->description</td>
         
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
    $this->log->showLog(3,"Access Quotation getInputForm()");
       if($o->track1_id=="")
                $o->track1_id=0;
       if($o->track2_id=="")
               $o->track2_id=0;
       if($o->track3_id=="")
               $o->track3_id=0;
    
    if($action=="new"){
        $tableheader="New Quotation";
         $attnoption="<option value='0'>Null</option>";
        $uidoption= $ctrl->getSelectUsers($userid);
        $termsoption="<option value='0'>Null</option>";
        $addressoption="<option value='0'>Null</option>";
        $currencyoption="<option value='0'>Null</option>";
        $branchctrl=$ctrl->selectionOrganization($userid, $defaultorganization_id);
        $this->quotation_id=0;
        $this->document_no=$this->getNextNo();
        $this->document_date=date("Y-m-d",time());
        $this->exchangerate=1;
        $this->subtotal=0;
        $this->localamt=0;
    }
    else{
        $tableheader="Edit Quotation";
         include_once "../simantz/class/SelectCtrl.inc.php";

    $ctrl= new SelectCtrl();
    include_once "../bpartner/class/BPSelectCtrl.inc.php";
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

$grid=$this->getGrid($this->quotation_id);
if($this->issotrx==1)
        $bpartnertype="isdebtor";
else
        $bpartnertype="iscreditor";
if($this->quotation_status=="S"){
    $selectquotestatus_u="";
 $selectquotestatus_f="";
 $selectquotestatus_s="selected='selected'";
}
elseif($this->quotation_status=="F"){
    $selectquotestatus_u="";
 $selectquotestatus_f="selected='selected'";
 $selectquotestatus_s="";
}
else
    {
    $selectquotestatus_u="selected='selected'";
 $selectquotestatus_f="";
 $selectquotestatus_s="";
    }
    $html =<<< HTML

<div id="idApprovalWindows" style="display:none"></div>
<div id='blanket' style='display:none;'></div>




    
    <br/>
    <div id='centercontainer'>
    <div align="center" >
    <table style="width:990px;text-align: left; " >
        <tr><td align="left">$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr></table>
$noperm

    <div id='errormsg' class='red' style='display:none'></div>
<form onsubmit='return false' method='post' name='frmQuotation' id='frmQuotation'  action='$this->quotationfilename'  enctype="multipart/form-data">
   <table style="text-align: left; width: 990px;" border="0" cellpadding="0" cellspacing="1"  class="searchformblock">
    <tbody>
        <tr>
        <td colspan="4" rowspan="1" align="center" id="idHeaderText" class="searchformheader" >$tableheader</td>
        </tr>
        <tr>
          <td class="head">Quotation No</td>
          <td class="even"><input name='spquotation_prefix' id='spquotation_prefix' value='$this->spquotation_prefix' size='3'>
                            <input name='document_no' id='document_no'  value='$this->document_no' size='10'>
                    Branch <select id='organization_id' name='organization_id'>&nbsp; $branchctrl</select></td>
          <td class="head">Business Partner</td>
          <td class="even"><div style="float: left">
              <ntb:Combo id="cmbbpartner_id" Mode="classic" theme="$nitobicombothemes" InitialSearch="$this->bpartner_name" onselectevent="chooseBPartner();">
             <ntb:ComboTextBox Width="250px" DataFieldIndex=1 ></ntb:ComboTextBox>
             <ntb:ComboList Width="300px" Height="200px" DatasourceUrl="../bpartner/bpartnerlookup.php?action=searchbpartnercombo&showNull=Y&bpartner_id=$this->bpartner_id" PageSize="25" >
             <ntb:ComboColumnDefinition Width="130px" DataFieldIndex=1 ></ntb:ComboColumnDefinition>
             <ntb:ComboMenu icon="images/add.gif" OnClickEvent="window.open('../bpartner/bpartner.php')" text=" &nbsp;Add product...">
             </ntb:ComboList>
            </ntb:Combo></div><div style="float: left"><a onclick="zoomBPartner()"><img src="../simantz/images/zoom.png"></a></div>
          </td>
     </tr>
     <tr>
        <td class="head">Date (YYYY-MM-DD)</td>
          <td class="even">
            <input id='document_date' name='document_date'  size='10'  value='$this->document_date'>
            <input id='btnquotationdate' type='button' class='btndate' onclick="$this->showCalendar" value="Date"></td>
          <td class="head">Attn To </td>
          <td class="even"><select id='contacts_id' name='contacts_id' >$attnoption</select></td>
     </tr>
     <tr>
      <td class="head">Terms</td>
      <td class="even"><select id='terms_id' name='terms_id'>$termsoption</select></td>
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
       <td class="head" rowspan="2">Address</td>
       <td class="even" rowspan="2"><select id='address_id' name='address_id' onchange=updateAddressText()>$addressoption</select><br/>
        <textarea id='address_text' name='address_text' cols='30' rows='3'>$this->address_text</textarea>
        </td>
         <td class="head">Currency</td>
          <td class="even">
                    <select id='currency_id' name='currency_id' onchange=comparecurrency()>$currencyoption</select> Exchange rate: MYR<input size='8' id='exchangerate' onchange=updateCurrency() value="$this->exchangerate" name="exchangerate"><br/>
     </td>
  </tr>
<tr>
         <td class="head">Short Title</td>
          <td class="even">
                    <input id='quotation_title' name='quotation_title' value="$this->quotation_title"></td>
            </tr>
  <tr>
    <td class="head" colspan='2'>
            <a onclick='javascript:addLine(1)'>Add Line [+]</a>     
        <input name='save' onclick='saverecord(0)' type='submit' id='submit' value='Save'>
        <input name='save' onclick='saverecord(1);' type='submit' id='submit' value='Complete'>
        <input name='save' onclick='deleterecord()' type='submit' id='delete' value='Delete'>
            <input name='action' id='action' value='ajaxsave'  type="hidden">
          <input type="button" value="Reload" onclick=javascript:reloadQuotation()>
            <input type="button" value="Preview" onclick=javascript:previewQuotation()>
        <input name='quotation_id' id='quotation_id'  value='$this->quotation_id'  title='quotation_id' type='hidden'>
        <input name='iscomplete'  id='iscomplete' value='$this->iscomplete'  title='iscomplete' type='hidden'>
            </td>
              <td class="head">Success or Failed</td>
            <td class="even"><select name="quotation_status" id="quotation_status">
                            <option value="" $selectquotestatus_u>Unknown</option>
                            <option value="S" $selectquotestatus_s>Success</option>
                            <option value="F" $selectquotestatus_f>Failed</option>
                        </select></td>
</tr>
<tr><td colspan='4'>
    <div id='detaildiv'>
    $grid
           <div style="width:895px;text-align:right" >
            Total: <label id='lblsubtotal'><input id='subtotal' size="10" name='subtotal' readonly="readonly" value='$this->subtotal'></label><br/>
          <input id='localamt' size="5" type='hidden' name='localamt' readonly="readonly"  value='$this->localamt'>
            </div>
</div>
</td></tr>
 <td class="head">Description</td>
<td class="even" colspan='2'><textarea cols='70' rows='3' id='description'  name='description'>$this->description</textarea>
          <div id="temp" $display><a onclick="openWindowTemp()" style='cursor:pointer'><u>Browse Template<u></a>
          <a onclick="openWindowsaveTemp()" style='cursor:pointer'><u>Save Template<u></a></div>
            </td>
            <td rowspan="3">
</tr><tr>
   <td class="head">Note</td>
<td class="even" colspan='2'><textarea cols='70' rows='3' id='note'  name='note'>$this->note</textarea></td>
</tr></table>
</form>


HTML;
    return $html;
   }

public function getGrid($quotation_id=0){
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
   <ntb:grid id="quotationgrid"
     mode="livescrolling"
     toolbarenabled="false"
     $permctrl
     singleclickeditenabled="true"
     gethandler="$this->quotationfilename?action=searchquotationline&quotation_id=$this->quotation_id"
     savehandler="$this->quotationfilename?action=saveQuotationline"
     rowheight="70"
     width="1060px"
     height="300"
     onhtmlreadyevent="optimizegridview()"
     onaftersaveevent="savedone(eventArgs)"
     autosaveenabled="false"
     theme="$nitobigridthemes">

<ntb:columns>    
        <ntb:numbercolumn classname="{\$rh}" xdatafld="seqno" sortenabled="false" visible="false"></ntb:numbercolumn>
        <ntb:textcolumn classname="{\$rh}" width="170px" label="Subject"  xdatafld="subject" sortenabled="false" $editable></ntb:textcolumn>
        <ntb:textcolumn classname="{\$rh}" width="190px" label="Description"  xdatafld="description" maxlength='10000' sortenabled="false" $editable>
                        <ntb:textareaeditor></ntb:textareaeditor></ntb:textcolumn>
        <ntb:numbercolumn classname="{\$rh}" label="U.Price" mask="#0.00" width="50" $editable xdatafld="uprice" sortenabled="false" onaftercelleditevent="updateCurrentRow(eventArgs)">
                        </ntb:numbercolumn>
        <ntb:numbercolumn classname="{\$rh}" label="Qty" width="50" mask="#0.00" xdatafld="qty" $editable sortenabled="false" onaftercelleditevent="updateCurrentRow(eventArgs)">
                    </ntb:numbercolumn>
        <ntb:textcolumn classname="{\$rh}" label="UOM"  width="50" xdatafld="uom" sortenabled="false" $editable></ntb:textcolumn>
        <ntb:numbercolumn classname="{\$rh}" label="Amount" mask="#0.00" width="50"  xdatafld="amt" sortenabled="false"  editable="false"></ntb:numbercolumn>
        <ntb:textcolumn label="Del"   xdatafld="imgdel" $showdelete  width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:deleteLine()" align="right">
              <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor></ntb:textcolumn>
        <ntb:textcolumn  label="Log" classname="{\$rh}"  xdatafld="info"   width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlog()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
        <ntb:textcolumn classname="{\$rh}" label="IV"  visible="false"   xdatafld="quotation_id" sortenabled="false"></ntb:textcolumn>
        <ntb:textcolumn classname="{\$rh}" label="ID" visible="false" xdatafld="quotationline_id" editable="false"></ntb:textcolumn>
  </ntb:columns>
</ntb:grid>


_XML_;

}

public function GetTempWindow(){
   global $nitobigridthemes,$havewriteperm,$defcurrencycode;

        $sql = "SELECT * FROM simerp_descriptiontemp order by descriptiontemp_name ASC";
        $this->log->showLog(4,"GetTempWindow :" . $sql . "<br>");
        $query=$this->xoopsDB->query($sql);

echo <<< EOF
<div class="dimBackground"></div>
<div align="center" >
 <form action="course.php" method="POST" name="frmDoc" id="frmDocid" enctype="multipart/form-data">
    <input type="hidden" id="course_id" name="course_id" value="$this->course_id">
    <input type="hidden" name="action" value="updatedoc">
    <input type="hidden" name="intake_id" id="intake_id" value="">
<div style="height:480px;overflow:auto;"  class="floatWindow" id="tblSub">
<table>
 <tr>
  <td astyle="vertical-align:middle;" align="center">

    <table class="" style="width:800px">

       <tr class="tdListRightTitle" >
          <td colspan="4">
                <table><tr>
                <td id="idHeaderText" align="center">Description Template</td>
                <td align="right" width="30px"><img src="../simbiz/images/close.png" onclick="closeWindow();" style="cursor:pointer" title="Close"></td>
                </tr></table>
          </td>
       </tr>

       <tr>
          <td align="left" class="searchformblock">
            <table  align="left">

               <tr>
                  <td class="tdListRightTitle" style="width:20%">Description Name</td>
                  <td class="tdListRightTitle" style="width:70%">Content</td>
                  <td class="tdListRightTitle" style="width:10%" align="center">Action</td>
               </tr>

EOF;
     $i=0;
     while($row=$this->xoopsDB->fetchArray($query)){
        $i++;
        if($rowtype=="odd")
        $rowtype="even";
        else
        $rowtype="odd";
        $descriptiontemp_id = $row['descriptiontemp_id'];
        $descriptiontemp_name = $row['descriptiontemp_name'];
        $descriptiontemp_content = $row['descriptiontemp_content'];
echo <<< EOF
             <tr>
                <td class="$rowtype">$descriptiontemp_name</td>
                <td class="$rowtype"><textarea cols="80" rows="6" name="desc" id="desc$descriptiontemp_id">$descriptiontemp_content</textarea></td>
                <td class="$rowtype" align="center"><img src="../simbiz/images/approval.gif" onclick="returndescription('desc$descriptiontemp_id');" style="cursor:pointer">
                                                    <img src="../simbiz/images/del.gif" onclick="deletedescription('$descriptiontemp_id');" style="cursor:pointer"></td>
             </tr>
EOF;
      }
echo <<< EOF
           </table>
         </td>
      </tr>
 </table>

    </td>
  </tr>
</table>
</div>
   </form>
</div>
EOF;

  }

public function includeTempFormJavescript(){

     $link="salesquotation.php";

 echo <<< EOF

  <script language="javascript" type="text/javascript">


// open temp window

    function openWindowTemp(){

        var data="action=gettempwindow";
            $.ajax({
                url: "$link",type: "POST",data: data,cache: false,
                success: function (xml) {
                            document.getElementById('idApprovalWindows').innerHTML = xml;
                            document.getElementById('idApprovalWindows').style.display = "";
                            self.parent.scrollTo(0,0);
                }});
    }

    function returndescription(descriptiontemp_id){

      document.getElementById('description').value = document.getElementById(descriptiontemp_id).value;
      closeWindow();
    }

    function deletedescription(descriptiontemp_id){
      if(confirm('Confirm Delete this Template?')){
        var data = "action=deletetemp&descriptiontemp_id="+descriptiontemp_id;
               document.getElementById('popupmessage').innerHTML="Please Wait...";
               popup('popUpDiv');
        $.ajax({
           url: "$link",type: "POST",data: data,cache: false,
             success: function (xml) {
                jsonObj = eval( '(' + xml + ')');
                var status = jsonObj.status;
                   if(status == 1){
                    closeWindow();
                   }
                popup('popUpDiv');
            }});
       }
    }

    function openWindowsaveTemp(){

        var data="action=getsavetempwindow";
            $.ajax({
                url: "$link",type: "POST",data: data,cache: false,
                success: function (xml) {
                            document.getElementById('idApprovalWindows').innerHTML = xml;
                            document.getElementById('idApprovalWindows').style.display = "";
                            document.getElementById('descriptiontemp_content').value = document.getElementById('description').value;
                            self.parent.scrollTo(0,0);
                }});
    }

    function savetemp(){

        var data = $("#frmTempid").serialize();
               document.getElementById('popupmessage').innerHTML="Please Wait...";
               popup('popUpDiv');
        $.ajax({
           url: "$link",type: "POST",data: data,cache: false,
             success: function (xml) {
                jsonObj = eval( '(' + xml + ')');
                var status = jsonObj.status;
                   if(status == 1){
                    closeWindow();
                   }
                popup('popUpDiv');
            }});
    }
    function closeWindow(){
      document.getElementById('idApprovalWindows').style.display = "none";
      document.getElementById('idApprovalWindows').innerHTML = "";
    }

// end of open temp window


  </script>

EOF;

  }

public function GetSaveTempWindow(){
   global $nitobigridthemes,$havewriteperm,$defcurrencycode;

        $sql = "SELECT * FROM simerp_descriptiontemp order by descriptiontemp_name ASC";
        $this->log->showLog(4,"GetTempWindow :" . $sql . "<br>");
        $query=$this->xoopsDB->query($sql);

echo <<< EOF
<div class="dimBackground"></div>
<div align="center" >

 <form method="POST" name="frmTemp" id="frmTempid" enctype="multipart/form-data">
    <input type="hidden" name="action" value="savetemp">

<table>
 <tr>
  <td astyle="vertical-align:middle;" align="center">

    <table class="floatWindow" style="width:600px">

       <tr class="tdListRightTitle" >
          <td colspan="4">
                <table><tr>
                <td id="idHeaderText" align="center">Save Description Template</td>
                <td align="right" width="30px"><img src="../simbiz/images/close.png" onclick="closeWindow();" style="cursor:pointer" title="Close"></td>
                </tr></table>
          </td>
       </tr>

       <tr>
          <td align="left" class="searchformblock">
            <table  align="left">

              <tr>
                  <td class="tdListRightTitle" width="20px">Description Name</td>
                  <td colspan="3">&nbsp;</td>
              </tr>

              <tr>
                 <td class="even"><input size="50px" type="text" name="descriptiontemp_name" id="descriptiontemp_name"></td>
                 <td colspan="3"></td>
              </tr>

              <tr>
                 <td class="tdListRightTitle" colspan="4" >Description Content</td>
              </tr>

              <tr>
                <td class="even" colspan="4"><textarea cols="90" rows="6" name="descriptiontemp_content" id="descriptiontemp_content"></textarea></td>
             </tr>

              <tr>
                <td class="head" colspan="4" align="right"><input type="button" value="Save" onclick="savetemp()"></td>
             </tr>

           </table>
         </td>
      </tr>
 </table>

    </td>
  </tr>
</table>

   </form>
</div>
EOF;

  }

public function saveTemp(){
    global $defaultcurrency_id;
    include_once "../simantz/class/Save_Data.inc.php";
    global $defaultpicture,$uploadpath,$selectspliter,$xoopsDB,$xoopsUser,$defaultorganization_id;
    $save = new Save_Data();
    $timestamp=date("Y-m-d H:i:s",time());
    $createdby=$xoopsUser->getVar('uid');
    $uname=$xoopsUser->getVar('uname');

    $arrInsertField=array("descriptiontemp_name","descriptiontemp_content",
                                "created","createdby","updated","updatedby");

    $arrInsertFieldType=array("%s","%s","%s","%d","%s","%d");

    $arrvalue=array($this->descriptiontemp_name,
                    $this->descriptiontemp_content,
                    $timestamp,
                    $createdby.$selectspliter.$uname,
                    $timestamp,
                    $createdby.$selectspliter.$uname);

    return $save->InsertRecord("simerp_descriptiontemp", $arrInsertField, $arrvalue, $arrInsertFieldType, $this->descriptiontemp_name,"descriptiontemp_id");
 }

public function deleteTemp($descriptiontemp_id) {
    include_once "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
    return $save->DeleteRecord("simerp_descriptiontemp","descriptiontemp_id ",$descriptiontemp_id ,$descriptiontemp_id,1);
  }

public function showQuotationline($wherestring){
      include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin,$url;

   $tablename="sim_bpartner_quotationline";
   $this->log->showLog(2,"Access showQuotationline($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        $orderbystring="seqno,quotationline_id";

       

      ////$sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $sql = "SELECT quotationline_id,seqno,subject,description,uprice,qty,uom".
            ",amt,quotation_id FROM ".
            " $tablename i $wherestring ORDER BY $orderbystring ";

      $this->log->showLog(4,"With SQL: $sql $sortdirection");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("quotationline_id");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("subject");
     	$getHandler->DefineField("description");
     	$getHandler->DefineField("uprice");
     	$getHandler->DefineField("qty");
     	$getHandler->DefineField("uom");
        $getHandler->DefineField("rh");
        $getHandler->DefineField("quotation_id");
        $getHandler->DefineField("imgadd");
        $getHandler->DefineField("amt");
        


	$currentRecord = 0; // This will assist us finding the ordinalStart position
        $rh="odd";
        $temp_parent_id = 0;
      while ($row=$xoopsDB->fetchArray($query))
     {

            $url_addimg = "images/add_line.gif";

             if($rh=="odd")
                    $rh="even";
             else
                    $rh="odd";
             
          
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){

             $getHandler->CreateNewRecord($row['quotationline_id']);
             $getHandler->DefineRecordFieldValue("quotationline_id", $row['quotationline_id']);
             $getHandler->DefineRecordFieldValue("seqno",$row['seqno']);
             $getHandler->DefineRecordFieldValue("description", $row['description']);
             $getHandler->DefineRecordFieldValue("subject", $row['subject']);
             $getHandler->DefineRecordFieldValue("amt", $row['amt']);
             $getHandler->DefineRecordFieldValue("uprice",$row['uprice']);
             $getHandler->DefineRecordFieldValue("qty", $row['qty']);
             $getHandler->DefineRecordFieldValue("uom", $row['uom']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->DefineRecordFieldValue("amt",$row['amt']);             
             $getHandler->DefineRecordFieldValue("quotation_id",$row['quotation_id']);
             $getHandler->DefineRecordFieldValue("imgadd",$url_addimg);
             $getHandler->DefineRecordFieldValue("info","../simantz/recordinfo.php?tablename=sim_bpartner_quotationline&idname=quotationline_id&title=Quotation&id=".$row['quotationline_id']);

             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showQuotationline()");
}

public function showSearchGrid($wherestring){
      include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];

        $ordinalStart=$_GET["StartRecord"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

   $tablename="sim_bpartner_quotation";
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
           $sortcolumn="concat(i.payment_prefix,i.document_no)";

        }
        if(empty($sortdirection)){
           $sortdirection="DESC";
        }



                $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
        if(empty($sortcolumn)){
           $sortcolumn="concat(i.spquotation_prefix,i.document_no)";

        }
        if(empty($sortdirection)){
           $sortdirection="DESC";
        }
        
    $searchiscomplete=$_GET['searchiscomplete'];
       if($searchiscomplete!=""){
           if($searchiscomplete=="Y")
                $searchiscomplete=1;
           else
                $searchiscomplete=0;
           
           $wherestring.=" and i.iscomplete=$searchiscomplete";
       }
       $searchquotation_no=$_GET['searchquotation_no'];
       if($searchquotation_no!="")
           $wherestring.=" and concat(i.spquotation_prefix,i.document_no) LIKE '%$searchquotation_no%'";

        $searchbpartner_id=$_GET['searchbpartner_id'];
       if($searchbpartner_id!=0)
           $wherestring.=" and i.bpartner_id = $searchbpartner_id";

       $searchcurrency_id=$_GET['searchcurrency_id'];
       if($searchcurrency_id>0)
           $wherestring .= " and i.currency_id=$searchcurrency_id";

       $datefrom=$_GET['datefrom'];
       $dateto=$_GET['dateto'];

       if($datefrom=="")
            $datefrom="0000-00-00";
       if($dateto=="")
            $dateto="9999-12-31";

       $wherestring.=" and i.document_date  BETWEEN '$datefrom' AND '$dateto'" ;

        


    
      ////$sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $sql = "SELECT i.quotation_id,  concat(i.spquotation_prefix,i.document_no) as quotation_no, i.document_date, i.subtotal, i.iscomplete,  ".
                " bp.bpartner_id, bp.bpartner_no,bp.bpartner_name, t.terms_name, c.currency_code, u.uname,o.organization_code,i.quotation_status,i.quotation_title  ".
            "  FROM sim_bpartner_quotation i ".
              " left join sim_bpartner bp on i.bpartner_id=bp.bpartner_id ".
            " left join sim_terms t on t.terms_id=i.terms_id ".
            " left join sim_currency c on c.currency_id=i.currency_id ".
            " left join sim_users u on u.uid=i.preparedbyuid ".
              " left join sim_organization o on o.organization_id=i.organization_id where i.issotrx=$this->issotrx".

        " $wherestring ORDER BY $sortcolumn $sortdirection";

      $this->log->showLog(4,"With SQL: $sql $sortdirection");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("quotation_id");
        $getHandler->DefineField("bpartner_id");
        $getHandler->DefineField("quotation_no");
        $getHandler->DefineField("document_date");
     	$getHandler->DefineField("subtotal");
        $getHandler->DefineField("iscomplete");
     	$getHandler->DefineField("bpartner_no");
     	$getHandler->DefineField("bpartner_name");
     	$getHandler->DefineField("terms_name");
        $getHandler->DefineField("currency_code");
        $getHandler->DefineField("uname");
        $getHandler->DefineField("rh");
        $getHandler->DefineField("gridlink");
        $getHandler->DefineField("quotation_title");
        $getHandler->DefineField("quotation_status");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
        $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {


             if($rh=="odd")
                    $rh="even";
             else
                    $rh="odd";
             $gridlink="gridlink $rh";
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

             $getHandler->CreateNewRecord($row['quotation_id']);
             $getHandler->DefineRecordFieldValue("quotation_id", $row['quotation_id']);
             $getHandler->DefineRecordFieldValue("bpartner_id",$row['bpartner_id']);
             $getHandler->DefineRecordFieldValue("quotation_no", $row['quotation_no']);
             $getHandler->DefineRecordFieldValue("document_date", $row['document_date']);
             $getHandler->DefineRecordFieldValue("subtotal", $row['subtotal']);

             $getHandler->DefineRecordFieldValue("iscomplete",$iscomplete);
             $getHandler->DefineRecordFieldValue("bpartner_no",$row['bpartner_no']);
             $getHandler->DefineRecordFieldValue("bpartner_name", $row['bpartner_name']);
             $getHandler->DefineRecordFieldValue("terms_name", $row['terms_name']);
             $getHandler->DefineRecordFieldValue("currency_code", $row['currency_code']);
             $getHandler->DefineRecordFieldValue("organization_code",$row['organization_code']);
             $getHandler->DefineRecordFieldValue("quotation_title",$row['quotation_title']);
             $getHandler->DefineRecordFieldValue("quotation_status",$row['quotation_status']);
            
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->DefineRecordFieldValue("gridlink",$gridlink);
             $getHandler->DefineRecordFieldValue("edit","$this->quotationfilename?action=$edit&quotation_id=".$row['quotation_id']);

             $getHandler->SaveRecord();
             }
      }
      $getHandler->setErrorMessage($currentRecord);
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showQuotationline()");
}

public function fetchQuotation($quotation_id){
    
     $this->log->showLog(3,"Access fetchQuotation($quotation_id)");
      $sql="SELECT i.*,concat(bp.bpartner_name,'(', bp.bpartner_no,')' ) as bpartner_name,o.organization_code,
            t.terms_name,c.contacts_name, u.uname
                FROM sim_bpartner_quotation i
                left join sim_bpartner bp on i.bpartner_id=bp.bpartner_id
                left join sim_organization o on o.organization_id=i.organization_id
                left join sim_terms t on t.terms_id=i.terms_id
                left join sim_users u on u.uid=i.preparedbyuid
                left join sim_contacts c on c.contacts_id=i.contacts_id
                where quotation_id=$quotation_id";
     $query=$this->xoopsDB->query($sql);
     while($row=$this->xoopsDB->fetchArray($query)){
         $this->quotation_id=$quotation_id;
         $this->document_no=htmlspecialchars($row['document_no']);
         $this->bpartner_name=htmlspecialchars($row['bpartner_name']);
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
         $this->preparedbyname=htmlspecialchars($row['uname']);
         $this->contacts_name=htmlspecialchars($row['contacts_name']);
         $this->quotation_title=htmlspecialchars($row['quotation_title']);
         $this->terms_name=$row['terms_name'];
         $this->ref_no=htmlspecialchars($row['ref_no']);
         $this->description=htmlspecialchars($row['description']);
         $this->bpartner_id=$row['bpartner_id'];
         $this->iscomplete=$row['iscomplete'];
         $this->spquotation_prefix=$row['spquotation_prefix'];
         $this->issotrx=$row['issotrx'];
         $this->terms_id=$row['terms_id'];
         $this->contacts_id=$row['contacts_id'];
         $this->preparedbyuid=$row['preparedbyuid'];
         $this->salesagentname=htmlspecialchars($row['salesagentname']);
         $this->isprinted=$row['isprinted'];
         $this->localamt=$row['localamt'];
         $this->address_id=$row['address_id'];
         $this->address_text=htmlspecialchars($row['address_text']);
         $this->exchangerate=$row['exchangerate'];
         $this->note=$row['note'];
         $this->quotation_status=$row['quotation_status'];
         $this->log->showLog(4,"Fetch data successfully");

         return true;
     }
     $this->log->showLog(4,"Cannot fetch quotation with SQL: $sql");
     return false;

 }
 public function insertQuotation( ) {

     include include "../simantz/class/Save_Data.inc.php";;
    $save = new Save_Data();

    $arrInsertField=array(
    "document_no",
    "organization_id",
    "documenttype",
    "document_date",
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
    "spquotation_prefix",
    "issotrx",
    "terms_id",
    "contacts_id",
    "preparedbyuid",
    "salesagentname",
    "isprinted",
    "localamt",
    "address_text",
        "address_id","note","quotation_title","quotation_status","iscomplete"
);
    $arrInsertFieldType=array(
    "%d",
    "%d",
    "%d",
    "%s",
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
    "%s",
    "%d",
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%f",
    "%s",
    "%d",
    "%s",
         "%s",
        "%s","%d");
    $arrvalue=array($this->document_no,
   $this->organization_id,
   $this->documenttype,
   $this->document_date,
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
   $this->spquotation_prefix,
   $this->issotrx,
   $this->terms_id,
   $this->contacts_id,
   $this->preparedbyuid,
   $this->salesagentname,
   $this->isprinted,
   $this->localamt,
   $this->address_text,
   $this->address_id,
   $this->note,
        $this->quotation_title,
        $this->quotation_status,$this->iscomplete);
    if($save->InsertRecord($this->tablename,   $arrInsertField,
            $arrvalue,$arrInsertFieldType,$this->spquotation_prefix.$this->document_no,"quotation_id")){
            $this->quotation_id=$save->latestid;
            return $this->quotation_id;
            }
    else
            return false;

  }


 public function updateQuotation( ) {

     include include "../simantz/class/Save_Data.inc.php";;
    $save = new Save_Data();
    $arrUpdateField=array(
        "document_no",
    "document_date",
    "currency_id",
    "exchangerate",
    "subtotal",
    "updated",
    "updatedby",
    "itemqty",
    "ref_no",
    "description",
    "bpartner_id",
    "spquotation_prefix",
    "terms_id",
    "contacts_id",
    "preparedbyuid",
    "salesagentname",
    "isprinted",
    "localamt",
    "address_text",
        "address_id",
        "organization_id",
        "note",
        "quotation_title",
        "quotation_status",
        "iscomplete"
);
    $arrUpdateFieldType=array(
        "%d",
    "%s",
    "%d",
    "%f",
    "%f",
    "%s",
    "%d",
    "%d",
    "%s",
    "%s",
    "%d",
    "%s",
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%f",
    "%s",
        "%d",
        "%d",
        "%s",
        "%s",
        "%s",
        "%d"
);
    $arrvalue=array($this->document_no,
   $this->document_date,
   $this->currency_id,
   $this->exchangerate,
   $this->subtotal,
   $this->updated,
   $this->updatedby,
   $this->itemqty,
   $this->ref_no,
   $this->description,
   $this->bpartner_id,
   $this->spquotation_prefix,
   $this->terms_id,
   $this->contacts_id,
   $this->preparedbyuid,
   $this->salesagentname,
   $this->isprinted,
   $this->localamt,
   $this->address_text,
   $this->address_id,
        $this->organization_id,
        $this->note,
        $this->quotation_title,
        $this->quotation_status,
        $this->iscomplete
        );

    if( $save->UpdateRecord($this->tablename, "quotation_id",
                $this->quotation_id,
                    $arrUpdateField, $arrvalue,  $arrUpdateFieldType,$this->spquotation_prefix.$this->document_no))
            return true;
    else
            return false;

  }

  public function deleteQuotation($quotation_id){
include "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
    $this->log->showLog(3,"Access deleteQuotation($quotation_id)");
    
   if($this->fetchQuotation($quotation_id)){
   
    return $save->DeleteRecord("sim_bpartner_quotation","quotation_id",$quotation_id,$this->spquotation_prefix.$this->document_no,1);
   }
   else
       return false;

}
public function saveQuotationLine(){
        $this->log->showLog(3,"Access saveQuotationLine");
            include "../simantz/class/nitobi.xml.php";
            include_once "../simantz/class/Save_Data.inc.php";

            global $xoopsDB,$xoopsUser;
            $saveHandler = new EBASaveHandler();
            $saveHandler->ProcessRecords();
            $timestamp=date("Y-m-d H:i:s",time());
            $createdby=$xoopsUser->getVar('uid');
            $uname=$xoopsUser->getVar('uname');
            $uid=$xoopsUser->getVar('uid');


        $tablename="sim_bpartner_quotationline";

            $save = new Save_Data();
            $insertCount = $saveHandler->ReturnInsertCount();
            $this->log->showLog(3,"Start Insert($insertCount records)");

    if ($insertCount > 0)
    {
           $arrInsertField=array(
                "seqno","subject","description","uprice","qty","uom",
                "amt", "quotation_id", "created","createdby","updated","updatedby");
              $arrInsertFieldType=array(
                "%d", "%s", "%s",  "%f","%f","%s",

                  "%f","%d","%s","%d","%s","%d");
    // Yes there are INSERTs to perform...
     for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
     {

         $arrvalue=array(
             $saveHandler->ReturnInsertField($currentRecord, "seqno"),
             $saveHandler->ReturnInsertField($currentRecord, "subject"),
             $saveHandler->ReturnInsertField($currentRecord, "description"),
             $saveHandler->ReturnInsertField($currentRecord, "uprice"),
             $saveHandler->ReturnInsertField($currentRecord, "qty"),
             $saveHandler->ReturnInsertField($currentRecord, "uom"),
             $saveHandler->ReturnInsertField($currentRecord, "amt"),
             $saveHandler->ReturnInsertField($currentRecord, "quotation_id"),
                    $timestamp,
                    $createdby,
                    $timestamp,
                    $createdby);
         $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "subject");
         $save->InsertRecord($tablename, $arrInsertField, $arrvalue, $arrInsertFieldType,$controlvalue,"quotationline_id");
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

        $arrUpdateField=array(
                "seqno", "subject", "description",  "uprice", "qty","uom",
                 "amt", "updated","updatedby");
              $arrUpdateFieldType=array( "%d", "%s","%s","%f","%f","%s",
                  "%f","%s","%d");


     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
     {

            $arrvalue=array(
                     $saveHandler->ReturnUpdateField($currentRecord, "seqno"),
             $saveHandler->ReturnUpdateField($currentRecord, "subject"),
             $saveHandler->ReturnUpdateField($currentRecord, "description"),
                $saveHandler->ReturnUpdateField($currentRecord, "uprice"),
             $saveHandler->ReturnUpdateField($currentRecord, "qty"),
             $saveHandler->ReturnUpdateField($currentRecord, "uom"),
             $saveHandler->ReturnUpdateField($currentRecord, "amt"),
                    $timestamp,
                    $createdby);
            $this->log->showLog(3,"***updating record($currentRecord), quotationline:subject".
                    $saveHandler->ReturnUpdateField($currentRecord, "subject"));

             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "subject");

             $save->UpdateRecord($tablename, "quotationline_id", $saveHandler->ReturnUpdateField($currentRecord,"quotationline_id"),
                        $arrUpdateField, $arrvalue, $arrUpdateFieldType,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }

     }
    }

    $ispurge=0;
    $deleteCount = $saveHandler->ReturnDeleteCount();
    $this->log->showLog(3,"Start delete/purge($deleteCount records)");
    

    if ($deleteCount > 0){
      for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
       
          $record_id=$saveHandler->ReturnDeleteField($currentRecord);
          $this->log->showLog(3,"delete: $currentRecord,$record_id");
     
        $controlvalue=$this->getQuotationLineSubject($record_id);
     

        $save->DeleteRecord("sim_bpartner_quotationline","quotationline_id",$record_id,$controlvalue,1);

      }

      }

    if($this->failfeedback!="")
    $this->failfeedback="Warning!<br/>\n".$this->failfeedback;
    $saveHandler->setErrorMessage($this->failfeedback);
    $saveHandler->CompleteSave();

    }


public function getQuotationLineSubject($quotationline_id){

    $sql="select concat(subject,'(',i.spquotation_prefix,i.document_no,')')  as subject from sim_bpartner_quotationline il
            inner join sim_bpartner_quotation i on il.quotation_id=i.quotation_id
        where il.quotationline_id=$quotationline_id";
    $this->log->showLog(3,"access getQuotationLineSubject($quotationline_id)");
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



global $nitobigridthemes,$url,$ctrl,$bpctrl;

$rowsperpage = 20;
  $new_button = $this->getFormButton("Add New","$this->quotationfilename");
  $this->currencyctrl=$ctrl->getSelectCurrency(0,"Y");
  include XOOPS_ROOT_PATH."/simantz/class/datepicker/class.datepicker.php";
  $bpartnerctrl=$bpctrl->getSelectBPartner(0,"Y","","searchbpartner_id","","N","searchbpartner_id");
  $dp = new datePicker();
  $dp->datePicker($url);
$dp->dateFormat="Y-m-d";
$showdatefrom=$dp->show("datefrom");
$showdateto=$dp->show("dateto");
  echo <<< EOF

  <script src="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.css">
  
      <script language="javascript" type="text/javascript">
        jQuery(document).ready((function (){nitobi.loadComponent('searchgrid');}));
        function viewquotation(){

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

        var searchquotation_no=document.getElementById("searchquotation_no").value;
        var searchbpartner_id=document.getElementById("searchbpartner_id");
        
        var datefrom =document.getElementById('datefrom').value;
        var dateto =document.getElementById('dateto').value;

        var searchcurrency_id =document.getElementById("searchcurrency_id").value;
        var searchiscomplete =document.getElementById("searchiscomplete").value;
        var searchTxt = "";

        if(datefrom != "")
        searchTxt += "Date From : "+datefrom+"<br/>";
        if(dateto != "")
        searchTxt += "Date To : "+dateto+"<br/>";

        if(searchquotation_no != "")
        searchTxt += "Quotation no : "+searchquotation_no+"<br/>";
        if(searchbpartner_id.value > 0){
        searchTxt += "BPartner : "+searchbpartner_id.options[searchbpartner_id.selectedIndex].text+"<br/>";
        }
        if(searchcurrency_id > 0){
           
            searchTxt += "Currency : "+searchcurrency_id+"<br/>";
        }
        if(searchiscomplete != ""){
        
            searchTxt += "Is Complete : "+searchiscomplete+"<br/>";
        }


	grid.getDataSource().setGetHandlerParameter('searchquotation_no',searchquotation_no);
	grid.getDataSource().setGetHandlerParameter('searchbpartner_id',searchbpartner_id.value);
  	grid.getDataSource().setGetHandlerParameter('datefrom',datefrom);
	grid.getDataSource().setGetHandlerParameter('dateto',dateto);

	grid.getDataSource().setGetHandlerParameter('searchcurrency_id',searchcurrency_id);
	grid.getDataSource().setGetHandlerParameter('searchiscomplete',searchiscomplete);

        document.getElementById('rightBox').innerHTML = searchTxt;
        //reload grid data

	grid.dataBind();   
     Pager.First('searchgrid');
return false;
   

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
   <tr> <td colspan="7" class="searchformheader">Search Quotation</td> </tr>

   <tr>
    <td class="searchformblock">

   <table >
    <tr>
      <td class="head">Quotation No</td>
      <td class="even"><input type="text" $colstyle name="searchquotation_no" id="searchquotation_no" value="$this->searchquotation_no"/></td>
      <td class="head">Business Partner</td>
      <td class="even">$bpartnerctrl</td>
   </tr>
    <tr>
      <td class="head">Date From</td>
      <td class="even"><input type="text" $colstyle name="datefrom" id="datefrom" value="$this->datefrom" size="10"/>
                        <input name="" type="button" onclick="$showdatefrom" value="Date"></td>
      <td class="head">Date To</td>
      <td class="even"><input type="text" $colstyle name="dateto" id="dateto" value="$this->dateto" size="10"/>
                        <input name="" type="button" onclick="$showdateto"  value="Date"></td>
   </tr>
   <tr>
      <td class="head">Currency</td>
      <td class="even">
         <select name="searchcurrency_id" id="searchcurrency_id" $colstyle>
           $this->currencyctrl
         </select>
      </td>
      <td class="head">Is Complete</td>
      <td class="even">
           <select $colstyle name="searchiscomplete" id="searchiscomplete">
             <option value="" >Null</option>
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

     <form name="frmQuotationListTable" action="$this->quotationfilename" method="POST" target="_blank" onsubmit='return validate()'>
     <input type="hidden"  name="action" id="action" value="">
     <input type="hidden" id="totalRowGrid" value="$rowsperpage">
<table style="width:700px;" class="searchformblock" >

 <tr >
    <td class="head tdPager" colspan="2" >
    
    <div id="pager_control" class="inline">
    <div id="pager_first" class="inline FirstPage" onclick="Pager.First('searchgrid');" onmouseover="this.className+=' FirstPageHover';" onmouseout="this.className='inline FirstPage';" style="margin:0;border-right:1px solid #B1BAC2;"></div>
    <div id="pager_prev" class="inline PreviousPage" onclick="Pager.Previous('searchgrid');" onmouseover="this.className+=' PreviousPageHover';" onmouseout="this.className='inline PreviousPage';" style="margin:0;"></div>
    <div class="inline" style="height:22px;top:3px;">
        <span class="inline">Page</span>
        <span class="inline" id="pager_current">0</span>
        <span class="inline">of</span>
        <span class="inline" id="pager_total">0</span>
    </div>
    <div id="pager_next" class="inline NextPage" onclick="Pager.Next('searchgrid');" onmouseover="this.className+=' NextPageHover';" onmouseout="this.className='inline NextPage';" style="margin:0;border-right:1px solid #B1BAC2;"></div>
    <div id="pager_last" class="inline LastPage" onclick="Pager.Last('searchgrid');" onmouseover="this.className+=' LastPageHover';" onmouseout="this.className='inline LastPage';" style="margin:0;"></div>
    </div>
    </td>
 </tr>

<tr ><td align="center" colspan="2">
<div>



    <ntb:grid id="searchgrid"
     mode="standard"
     gethandler="$this->quotationfilename?action=ajaxsearch"
     theme="$nitobigridthemes"
     rowhighlightenabled="true"
     toolbarenabled="false"
         ondatareadyevent="HandleReady(eventArgs);"
     editmode="false"
     width="970"
     height="420"
          rowheight="15"
        rowsperpage="$rowsperpage"
    >
   <ntb:columns>
       <ntb:textcolumn  classname="{\$rh}" width="40" label="Org"  xdatafld="organization_code"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="80" label="Quotation No"  xdatafld="quotation_no"  editable="false" ></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="70" label="Date"  xdatafld="document_date"  editable="false" ></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$gridlink}" width="220" label="BPartner" editable="false" xdatafld="bpartner_name"  oncelldblclickevent=javascript:doubleclickbpartner()></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="80" label="Terms"  xdatafld="terms_name"   editable="false" ></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="60" label="Currency"  xdatafld="currency_code"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="80" label="Amount"  xdatafld="subtotal"   editable="false" ></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="70" label="Complete"  xdatafld="iscomplete"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="70" label="Status"  xdatafld="quotation_status"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="70" label="Short Title"  xdatafld="quotation_title"   editable="false"></ntb:textcolumn>
       <ntb:textcolumn  classname="{\$rh}" width="40" label="Edit"  xdatafld="edit"  oncellclickevent="javascript:viewquotation()">
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


public function gridjs(){
global $defaultcurrency_id,$url;
  return  $js= <<< JS
<script src="$url/modules/simantz/include/validatetext.js" type="text/javascript"></script>

      <script language="javascript" type="text/javascript">
        $(document).ready((function (){
        nitobi.loadComponent('quotationgrid');
        nitobi.loadComponent('cmbbpartner_id');
       
        }));



        function chooseBPartner(){
              var bpid=document.getElementById("cmbbpartner_idSelectedValue0").value;
                   var data="action="+"getbpartnerinfo"+
                            "&bpartner_id="+bpid;

                    $.ajax({
                         url:"$this->quotationfilename",type: "POST",data: data,cache: false,
                             success: function (xml)
                             {
                           
                               var address=$(xml).find("address").text().replace(/{{{/g,"<").replace(/}}}/g,">");
                                var terms=$(xml).find("terms").text().replace(/{{{/g,"<").replace(/}}}/g,">");
                                 var contact=$(xml).find("contact").text().replace(/{{{/g,"<").replace(/}}}/g,">");
                                 var currency=$(xml).find("currency").text().replace(/{{{/g,"<").replace(/}}}/g,">");
                               var salesagent=$(xml).find("salesagent").text();
                               
                               
                                $("#address_id").html(address);
                                $("#contacts_id").html(contact);
                                $("#terms_id").html(terms);
                                $("#currency_id").html(currency);
                                document.getElementById("salesagentname").value=salesagent;
                                

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
                                 $.ajax({url:"$this->quotationfilename",type: "POST",data: checkaddresstext,cache: false,
                                    success: function (ad){
                                        document.getElementById("address_text").value=ad;
                                        }
                                });
          }

        function addLine(promptmsg){
        
          var myGrid = nitobi.getGrid('quotationgrid');
          var quotation_id=document.getElementById('quotation_id').value;

          myGrid.insertAfterCurrentRow();
          
          if(quotation_id>0){

               total_row = myGrid.getRowCount();

                                    for( var i = 0; i < total_row; i++ ) {
                                        var celly = myGrid.getCellObject( i, 9);
                                        celly.setValue(quotation_id);
                                    }
            }
        }

    function zoomBPartner(){
          var bpartner_id=document.getElementById("cmbbpartner_idSelectedValue0").value;
          if(bpartner_id>0)
           window.open ("../bpartner/bpartner.php?action=viewsummary&bpartner_id="+bpartner_id,"bpartner");
          else
          alert("You need to choose business partner!");
          }
          
    function viewlog(){
   	var g= nitobi.getGrid('quotationgrid');
        var selRow = g.getSelectedRow();
              var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
      window.open(cellObj,"");
    }

        function deleteLine(){
        if(confirm('Delete this line? It will force save current record and delete current line.')){
        var myGrid = nitobi.getGrid('quotationgrid');
            myGrid.deleteCurrentRow();
            saverecord(0);
        }
        }

        function validation(){
          var bpartner_id=document.getElementById("cmbbpartner_idSelectedValue0").value;
          var docdate=document.getElementById("document_date").value;
          if(bpartner_id=="" || bpartner_id==0){
          alert("Please choose bpartner");
          return false;
          }
          if(docdate=="" || !isDate(docdate)){
          alert("Please insert appropriate date");
          return false;
          }
          else
          return true;
          }




        function saverecord(iscomplete){
            if(!validation())
                return false;
            updateCurrentRow();
            if(iscomplete==1){
              if(!confirm("Confirm Complete?"))
                 return false
            }else{
              if(!confirm("Confirm Save?"))
                 return false
            }
            var iscompletectrl=document.getElementById("iscomplete");
             iscompletectrl.value=iscomplete;
              
                document.getElementById("popupmessage").innerHTML="Saving data...";
                popup('popUpDiv');
        
              var quotation_id=document.getElementById("quotation_id").value;
                var errordiv=document.getElementById("errormsg");
                errordiv.style.display="none";


                var data =$("#frmQuotation").serialize();
              

            $.ajax({
                 url: "$this->quotationfilename",type: "POST",data: data,cache: false,
                     success: function (xml) {
         
                     var status=$(xml).find("status").text();
                     
                     if(status==1){
                    var grid= nitobi.getGrid('quotationgrid');

                       errordiv.style.display="none";
                         total_row = grid.getRowCount();
              
                              if(quotation_id==0){
                                     var id=$(xml).find("quotation_id").text() ;

                                    document.getElementById("quotation_id").value=id;

                                          quotation_id=document.getElementById("quotation_id").value;

                           
                 
                                }
          
                             for( var i = 0; i < total_row; i++ ) {
                                        var celly = grid.getCellObject( i, 9);
                                        celly.setValue(quotation_id);
                                    }

                                        if( grid.getDataSource().getChangeLogXmlDoc().selectNodes("//ntb:data/*").length != 0 )
                                            {
                                               grid.save();
                                            }
                                            else
                                            {if(iscompletectrl.value==1)
                                                window.location="$this->quotationfilename?action=view&quotation_id="+quotation_id;
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
          var  grid = nitobi.getGrid('quotationgrid');
          grid.getDataSource().setGetHandlerParameter('quotation_id',document.getElementById("quotation_id").value);
          grid.dataBind();

          }
         function deleterecord(){

          if(confirm('Delete this record?')){
           var quotation_id=document.getElementById("quotation_id").value;
            var data="action=ajaxdelete&quotation_id="+quotation_id;
            $.ajax({
                 url: "$this->quotationfilename",type: "POST",data: data,cache: false,
                     success: function (xml) {
                       window.location="$this->quotationfilename";
                    }});
          }
        }

        function onclickcell(eventArgs){
          var  myGrid = nitobi.getGrid('quotationgrid');
          var  row = eventArgs.cell.getRow();
          var col = eventArgs.cell.getColumn();
          var myCell = myGrid.getCellObject(row, col);
          myCell.edit();
        }

        function updateCurrentRow(eventArgs){
            var  grid = nitobi.getGrid('quotationgrid');
          
              total_row = grid.getRowCount();
          
              var total=0;
              for( var i = 0; i < total_row; i++ ) {
                
                    var qty = grid.getCellObject( i, 3);
                    var uprice = grid.getCellObject( i, 4);
                    var amt = grid.getCellObject( i, 6);
                    
                    amt.setValue(qty.getValue() * uprice.getValue());
                    total=total+amt.getValue();
                    
              }
              document.getElementById("subtotal").value=total.toFixed(2);
          updateCurrency();
         
          }
          

        function optimizegridview(){
            var  grid = nitobi.getGrid('quotationgrid');
            total_row = grid.getRowCount();
            if(total_row==0)
                addLine();
            total_row = grid.getRowCount();
          grid.resize(960,total_row*70+40);

          }
       

              function updateCurrency(){
            document.getElementById("localamt").value=document.getElementById("subtotal").value*document.getElementById("exchangerate").value;
          }
        function reloadQuotation(){
          var action="edit";
          if(document.getElementById("iscomplete").value==1)
            action="view";
          
        if(document.getElementById("quotation_id").value>0)
        window.location="$this->quotationfilename?action="+action+"&quotation_id="+document.getElementById("quotation_id").value;
        else
        window.location="$this->quotationfilename";
        }
          
        function addNew(){
        window.location="$this->quotationfilename";
        }
        function previewQuotation(){
                window.open("view$this->quotationfilename?quotation_id="+document.getElementById("quotation_id").value)

        }

          function duplicateQuotation(){
            popup('popUpDiv');
          var quotation_id=document.getElementById("quotation_id").value;
            
           var data="action=duplicate&quotation_id="+quotation_id;
            $.ajax({
                        url: "$this->quotationfilename",type: "POST",data: data,cache: false,
                success: function (xml) {
                             if(xml != "")
                             jsonObj = eval( '(' + xml + ')');
                            document.getElementById('idApprovalWindows').innerHTML = xml;

                            document.getElementById('idApprovalWindows').style.display = "";
                              popup('popUpDiv');
                }
          });
          }

        function savedone(even){
          var  grid = nitobi.getGrid('quotationgrid');
          grid.getDataSource().setGetHandlerParameter('quotation_id',document.getElementById("quotation_id").value);
            grid.dataBind();
         
        }

    function reactivateQuotation(){
          var quotation_id=document.getElementById("quotation_id").value;
           var data="action=reactivate&quotation_id="+quotation_id;
            $.ajax({
                        url: "$this->quotationfilename",type: "POST",data: data,cache: false,
                success: function (xml) {
                             if(xml != ""){
                             jsonObj = eval( '(' + xml + ')');

                                if(jsonObj.status==1){
                                document.getElementById("iscomplete").value=0;
                                reloadQuotation();
                                }
                                else
                                alert("Cannot reactivate quotation! Msg: "+jsonObj.msg);
                                }
                                }
                   });
          
          }
    
        </script>
    
JS;
}


  public function getNextNo() {

   $sql="SELECT MAX(document_no ) + 1 as newno from sim_bpartner_quotation where issotrx=$this->issotrx";
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

    $this->addnewctrl='<form action="'.$this->quotationfilename.'" ><input type="submit" value="Add New"></form>';
        if($action=="search"){
    $this->searchctrl='';
    }
    else
    $this->searchctrl='<form action="'.$this->quotationfilename.'?action=search" ><input type="hidden" name="action" value="search"><input type="submit" value="Search"></form>';
  }

  public function duplicateQuotation(){
  $oldqid=$this->quotation_id;
    $query=$this->xoopsDB->query("SELECT * FROM  sim_bpartner_quotation q where q.quotation_id=$this->quotation_id");
    while($row=$this->xoopsDB->fetchArray($query)){

    $this->document_no=$this->getNextNo();
   $this->organization_id=$row['organization_id'];
   $this->documenttype=$row['documenttype'];
   $this->document_date=date("Y-m-d",time());
   $this->currency_id=$row['currency_id'];
   $this->exchangerate=$row['exchangerate'];
   $this->subtotal=$row['subtotal'];
  
   $this->itemqty=$row['itemqty'];
   $this->ref_no=$row['ref_no'];
   $this->description=$row['description'];
   $this->bpartner_id=$row['bpartner_id'];
   $this->spquotation_prefix=$row['spquotation_prefix'];
   $this->issotrx=$row['issotrx'];
   $this->terms_id=$row['terms_id'];
   $this->contacts_id=$row['contacts_id'];
   $this->preparedbyuid=$row['preparedbyuid'];
   $this->salesagentname=$row['salesagentname'];
   $this->isprinted=$row['isprinted'];
   $this->localamt=$row['localamt'];
   $this->address_text=$row['address_text'];
   $this->address_id=$row['address_id'];
   $this->note=$row['note'];
        $this->quotation_title=$row['quotation_title'];
        $this->quotation_status=$row['quotation_status'];
            $this->iscomplete=0;
       $qid= $this->insertQuotation();
       $this->log->showLog(2,"Generated quotation id: $qid");

    include_once "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
       if($qid>0){
           global  $timestamp,$createdby;
           $sqlline="SELECT * FROM  sim_bpartner_quotationline q where q.quotation_id=$oldqid";
                  $this->log->showLog(4,"Generated quotationline SQL: $sqlline");

            $queryline=$this->xoopsDB->query($sqlline);

                  $arrInsertField=array(
                "seqno","subject","description","uprice","qty","uom",
                "amt", "quotation_id", "created","createdby","updated","updatedby");

                  $arrInsertFieldType=array(
                "%d", "%s", "%s",  "%f","%f","%s",

                  "%f","%d","%s","%d","%s","%d");
                $this->log->showLog(2,"before insert quotationline");
            while($row=$this->xoopsDB->fetchArray($queryline)){
  
                 $arrvalue=array(
                     $row["seqno"],
                     $row["subject"],
                     $row["description"],
                     $row["uprice"],
                     $row["qty"],
                     $row["uom"],
                     $row["amt"],
                    $qid,
                            $timestamp,
                            $createdby,
                            $timestamp,
                            $createdby);
         $controlvalue=$row["subject"];
                           
       $this->log->showLog(2,"before insert quotationline");

         $save->InsertRecord("sim_bpartner_quotationline", $arrInsertField, $arrvalue, $arrInsertFieldType,$controlvalue,"quotationline_id");

      // Now we execute this query
     
                }





           
       }
       return array($qid,$this->spquotation_prefix.$this->document_no);
    }
    return array(0,"");
    
 //sim_bpartner_quotationline
  }
}

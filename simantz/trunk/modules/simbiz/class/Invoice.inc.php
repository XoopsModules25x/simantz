<?php

class Invoice{
    public $invoice_id;
    public $document_no;
    public $organization_id;
    public $documenttype;
    public $document_date;
    public $batch_id;
    public $currency_id;
    public $exchangerate;
    public $originalamt;
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
    public $spinvoice_prefix;
    public $issotrx;
    public $terms_id;
    public $contacts_id;
    public $preparedbyuid;
    public $salesagentname;
    public $isprinted;
    public $localamt;
    public $address_text;
    public $branch_id;
    public $tracking1_id;
    public $tracking2_id;
    public $tracking3_id;
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
    private $tableinvoice;
    private $tablename;
    private $tablecurrency;
    private $log;

  
   public function Invoice(){
	global $xoopsDB,$log,$tableinvoice,$tableinvoiceline,$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
        $this->organization_id=$defaultorganization_id;
	$this->log=$log;
        $this->tableorganization=$tableorganization;
	$this->tablecurrency=$tablecurrency;
	$this->tableinvoice=$tableinvoice;
        $this->tableinvoiceline=$tableinvoiceline;
        $this->tablename=$tableinvoice;
        $this->log->showLog(3,"Access Invoice()");
        $this->gridfieldstructure="invoiceline_id|seqno|subject|description|accounts_id|uprice|qty|uom|tax_id|branch_id|track1|track2|track3|originalamt|invoice_id|gstamt|granttotalamt";
        $this->gridfielddefault=" | | | | | | | | | | | | | | | | ";
        $this->gridfieldtype="text|text|text|text|text|text|text|text|text|text|text|text|text|text|text|text|text";
        $this->gridfieldarray=array(
                "a"=>"invoiceline_id",
                "b"=>"seqno",
                "c"=>"subject",
                "d"=>"description",
                "e"=>"accounts_id",
                "f"=>"uprice",
                "g"=>"qty",
                "h"=>"uom",
                "i"=>"tax_id",
                "j"=>"branch_id",
                "k"=>"track1",
                "l"=>"track2",
                "m"=>"track3",
                "n"=>"amt",
                "o"=>"invoice_id",
                "p"=>"gstamt",
                "q"=>"granttotalamt"
            );
        
           $this->gridfieldsortablearray=array(
                "a"=>"true",
                "b"=>"true",
                "c"=>"true",
                "d"=>"true",
                "e"=>"true",
                "f"=>"true",
                "g"=>"true",
                "h"=>"true",
                "i"=>"true",
                "j"=>"true",
                "k"=>"true",
                "l"=>"true",
                "m"=>"true",
                "n"=>"true",
                "o"=>"true",
                "p"=>"true",
                 "q"=>"true"
            );
                  $this->gridfieldtypearray=array(
                 "a"=>"number",
                "b"=>"integer",
                "c"=>"text",
                "d"=>"textarea",
                "e"=>"number",
                "f"=>"number",
                "g"=>"number",
                "h"=>"text",
                "i"=>"lookup",
                "j"=>"lookup",
                "k"=>"lookup",
                "l"=>"lookup",
                "m"=>"lookup",
                "n"=>"number",
                "o"=>"number",
                "p"=>"number",
                "q"=>"number"
            );
                  
        $this->gridfielddisplayarray=array(
                "a"=>"Invoice Line",
                "b"=>"No",
                "c"=>"Subject",
                "d"=>"Description",
                "e"=>"Accounts",
                "f"=>"U.Price",
                "g"=>"Qty",
                "h"=>"UOM",
                "i"=>"Tax",
                "j"=>"Branch",
                "k"=>"Track1",
                "l"=>"Track2",
                "m"=>"Track3",
                "n"=>"Amount",
                "o"=>"Invoice Id",
                "p"=>"GST Amount",
                "q"=>"Local Grant Total Amt"
            );

                $this->gridfieldwidtharray=array(
                "a"=>0,
                "b"=>25,
                "c"=>170,
                "d"=>230,
                "e"=>100,
                "f"=>60,
                "g"=>50,
                "h"=>40,
                "i"=>40,
                "j"=>45,
                "k"=>60,
                "l"=>60,
                "m"=>60,
                "n"=>55,
                "o"=>0,
                "p"=>0,
                "q"=>0
            );
   }

    public function getInputForm(){

    global $mandatorysign, $defaultorganization_id,$nitobitransgridthemes;
    $this->log->showLog(3,"Access Invoice getInputForm()");
    $attnoption="<option value='1'>Mr Muru</option>";
    $empoption="<option value='1'>Ks Tan</option>";
    $termsoption="<option value='1'>30 Days</option>";
    $addressoption="<option value='1'>Tafe Seremban</option>";
    $currencyoption="<option value='1'>MYR</option>";
    $branchoption="<option value='1'>HQ</option>";
    $tracking1option="<option value='0'>Null</option>";
    $tracking2option="<option value='0'>Null</option>";
    $tracking3option="<option value='0'>Null</option>";
    $grid=$this->getGrid($this->invoice_id);
   
    return "
     <A href='salesinvoice.php?action=showsearchform'>[Search]</a>
     <A href=javascript:addNew()>[Add New]</a>
     <A href=javascript:addPrintPreview()>[Print Preview]</a>
     <A href=javascript:delete()>[Delete]</a>
    <div id='centercontainer'>
   
    <br/>
    <div id='formdiv' class='formband'>

    <div id='errormsg' class='red' style='display:none'></div>
   
    <form onsubmit='return false'  action='salesinvoice.php'>
   
<b>New Invoice</b><br/>
   <table>
   <tr><td>
        <div class='divfield'>Invoice No <br/>
            <input id='spinvoice_prefix' value='$this->spinvoice_prefix'size='3'>
            <input id='document_no'  value='$this->document_no' size='15'>
        </div>
    
        <div class='divfield'>Business Partner <br/>
            <input id='bpartner_name' size='25'>
            <input id='bpartner_no' size='5'>
            <input id='bpartner_id' type='1hidden' size='2'  value='$this->bpartner_id'>
            <a href=javascript:searchBpartner()>search</a>
    </div>

      <div class='divfield'>Date (YYYY-MM-DD)<br/>
            <input id='document_date' size='10'  value='$this->document_date'>
            <input id='btninvoicedate' type='button' class='btndate'>
        </div>

</td></tr>
    <tr><td>
      
         <div class='divfield'>Attn To <br/>
        <select id='contacts_id' >$attnoption</select>
        </div>

    <div class='divfield'>Terms<br/>
           <select id='terms_id'>$termsoption</select>
        </div>


    <div class='divfield'>Ref. No<br/>
           <input id='ref_no' size='10'  value='$this->ref_no'>
        </div>

     <div class='divfield'>Prepared By<br/>
           <select id='preparedbyuid'>$empoption</select></div>

    <div class='divfield'>Sales Agent<br/>
           <input id='salesagentname'  value='$this->salesagentname'>
        </div>

</td></tr>
<tr><td>
    <div class='divfield'>Currency<br/>
            <select id='currency_id'>$currencyoption</select> Exchange rate: MYR  <input size='8' id='exchangerate'><br/>

            Base Amt<br/><input id='originalamt'  value='$this->originalamt'><br/>
            Local Amt<br/><input id='localamt'  value='$this->localamt'></div>

    <div class='divfield'>Address<br/>
        <select id='address_id'>$addressoption</select><br/>
    <textarea id='address_text' cols='30' rows='5'>$this->address_text</textarea>
        </div>

  
    </td></tr>
  <tr><td>

      <div class='divfield'>Branch <select id='branch_id'>$branchoption</select></div>
     <div class='divfield'>
        Tracking1
             <select id='tracking1_id'>$tracking1option</select>
            Tracking2
             <select id='tracking2_id'>$tracking2option</select>
            Tracking3
             <select id='tracking3_id'>$tracking3option</select>
        </div>
    <div class='divfield'>
   
        <input id='invoice_id'  value='$this->invoice_id'  title='invoice_id' type='1hidden'>
        <input id='iscomplete' value='$this->iscomplete'  title='iscomplete' type='hidden'>
        <input id='gridxml' name='gridxml'  value='' type='hidden'>

        <input id='organization_id' value='$defaultorganization_id'  title='organization_id'  type='hidden'>
        <input name='save' onclick='saverecord()' type='submit' id='submit' value='Save'>
        <input name='save' onclick='deleterecord()' type='submit' id='delete' value='Delete'>
            <input name='action' type='text' name='action' value='ajaxsave'  type='hidden'>
            
            </div>
          <div class='divfield'>
            <a href='javascript:addLine()'>Add Line</a>
              </div>
            <div class='divfield'>
            <a href='javascript:deleteLine()'>Delete Line</a>
            </div>
</td></tr>

</table>

    <div id='detaildiv'>
    $grid
</div>
  <div class='divfield'>Description<br/>
<textarea cols='70' rows='4' id='description'></textarea><br/></div>
  <div class='divfield'>Note<br/>
<textarea cols='70' rows='4' id='note'></textarea></div>
</form>
</div>


<div id='rightband' class='sideband' style=''>


<div id='helpdiv'>
<a href='help.php' target='_blank'>Help</a></div>


<div id='infodiv'>
<b>Financial Info</b>
<br/>Credit Status:
<br/>Paid Amount:
<br/>Posting History:
<br/>Posting Result:
<br/>
<br/><b>Shortcut</b>
<br/>Add Receipt
<br/>Add Credit Note
<br/>Print Statement
</div>
</div>
</div>";
   }


public function getGrid($invoice_id=0){
    global $permctrl, $windowsetting,$nitobigridthemes;
    $data="";
    if($invoice_id>0){
        
            $subsql="";
           foreach($this->gridfieldarray as $no =>$value)
            $subsql.="$value,";

            $subsql=substr_replace($subsql, "", -1);
            $sql="SELECT $subsql FROM $this->tableinvoiceline where invoice_id=$invoice_id";
            $query=$this->xoopsDB->query($sql);
            
            while($row=$this->xoopsDB->fetchArray($query)){
                $erow="";
                 foreach($this->gridfieldarray as $no =>$value)
                    $erow.= "$no=\"".$row[$value]."\" ";
                 $data.="<ntb:e $erow></ntb:e>\n";
            }
        
    
    }


    
    $columnlist="";
   foreach($this->gridfieldarray as $no =>$value){
   
    switch($this->gridfieldtypearray[$no]){

    case "textarea":

    $columnlist.="<ntb:textcolumn label='".$this->gridfielddisplayarray[$no]."' xdatafld='".$value.
                "'  sortenabled='".$this->gridfieldsortablearray[$no].
                "' width='".$this->gridfieldwidtharray[$no]."'> <ntb:textareaeditor></ntb:textareaeditor></ntb:textcolumn>\n";
                break;
    case "number":
    $columnlist.="<ntb:numbercolumn  label='".$this->gridfielddisplayarray[$no]."' xdatafld='".$value.
                "'  sortenabled='".$this->gridfieldsortablearray[$no].
                "' width='".$this->gridfieldwidtharray[$no]."'></ntb:numbercolumn>\n";
    break;
    case "integer":
    $columnlist.="<ntb:numbercolumn  label='".$this->gridfielddisplayarray[$no]."' xdatafld='".$value.
                "' mask='##0' sortenabled='".$this->gridfieldsortablearray[$no].
                "' width='".$this->gridfieldwidtharray[$no]."'></ntb:numbercolumn>\n";
    break;
 case "lookup":

    $columnlist.="<ntb:textcolumn label='".$this->gridfielddisplayarray[$no]."' xdatafld='".$value.
                "'  sortenabled='".$this->gridfieldsortablearray[$no].
                "' width='".$this->gridfieldwidtharray[$no]."'></ntb:textcolumn>\n";
                break;
    case "text":

    $columnlist.="<ntb:textcolumn label='".$this->gridfielddisplayarray[$no]."' xdatafld='".$value.
                "'  sortenabled='".$this->gridfieldsortablearray[$no].
                "' width='".$this->gridfieldwidtharray[$no]."'></ntb:textcolumn>\n";
                break;
    default:
        $columnlist.="";
        break;
    }
   }
   return $xml=<<< _XML_
     <ntb:grid id='invoicegrid'
  width='1015'
  height='250'
  mode='localnonpaging'
  toolbarenabled='false'
  datasourceid='dsinvoice'
                 rowhighlightenabled='false'
              oncellclickevent='onclickcell(eventArgs)'
            theme='$nitobigridthemes'>
 <ntb:datasources>
 <ntb:datasource id='dsinvoice'>
    <ntb:datasourcestructure FieldNames='$this->gridfieldstructure'
                Keys='invoiceline_id'
        types='$this->gridfieldtype'  defaults='$this->gridfielddefault'>
        </ntb:datasourcestructure>
  <ntb:data>
           $data
  </ntb:data>
 </ntb:datasource>
 </ntb:datasources>

<ntb:columns>
    $columnlist
   
    </ntb:columns>

</ntb:grid>


_XML_;

}

 public function fetchInvoice($invoice_id){
     $this->log->showLog(3,"Access fetchInvoice($invoice_id)");
     $sql="SELECT * FROM $this->tableinvoice where invoice_id=$invoice_id";
     $query=$this->xoopsDB->query($sql);
     while($row=$this->xoopsDB->fetchArray($query)){
         $this->invoice_id=$row['invoice_id'];
         $this->document_no=$row['document_no'];
         $this->organization_id=$row['organization_id'];
         $this->documenttype=$row['documenttype'];
         $this->document_date=$row['document_date'];
         $this->batch_id=$row['batch_id'];
         $this->amt=$row['amt'];
         $this->currency_id=$row['currency_id'];
         $this->exchangerate=$row['exchangerate'];
         $this->originalamt=$row['originalamt'];
         $this->created=$row['created'];
         $this->createdby=$row['createdby'];
         $this->updated=$row['updated'];
         $this->updatedby=$row['updatedby'];
         $this->itemqty=$row['itemqty'];
         $this->ref_no=$row['ref_no'];
         $this->description=$row['description'];
         $this->bpartner_id=$row['bpartner_id'];
         $this->iscomplete=$row['iscomplete'];
         $this->bpartneraccounts_id=$row['bpartneraccounts_id'];
         $this->spinvoice_prefix=$row['spinvoice_prefix'];
         $this->issotrx=$row['issotrx'];
         $this->terms_id=$row['terms_id'];
         $this->contacts_id=$row['contacts_id'];
         $this->preparedbyuid=$row['preparedbyuid'];
         $this->salesagentname=$row['salesagentname'];
         $this->isprinted=$row['isprinted'];
         $this->localamt=$row['localamt'];
         $this->address_text=$row['address_text'];
         $this->branch_id=$row['branch_id'];
         $this->tracking1_id=$row['tracking1_id'];
         $this->tracking2_id=$row['tracking2_id'];
         $this->tracking3_id=$row['tracking3_id'];
         $this->note=$row['note'];
         $this->log->showLog(4,"Fetch data successfully");

         return true;
     }
     $this->log->showLog(4,"Cannot fetch invoice with SQL: $sql");
     return false;

 }
 public function insertInvoice( ) {

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
    "originalamt",
    "created",
    "createdby",
    "updated",
    "updatedby",
    "itemqty",
    "ref_no",
    "description",
    "bpartner_id",
    "iscomplete",
    "bpartneraccounts_id",
    "spinvoice_prefix",
    "issotrx",
    "terms_id",
    "contacts_id",
    "preparedbyuid",
    "salesagentname",
    "isprinted",
    "localamt",
    "address_text",
    "branch_id",
    "tracking1_id",
    "tracking2_id",
    "tracking3_id");
    $arrInsertFieldType=array(
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%s",
    "%d",
    "%d",
    "%s",
    "%s",
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%s",
    "%d",
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
   $this->originalamt,
   $this->updated,
   $this->updatedby,
   $this->updated,
   $this->updatedby,
   $this->itemqty,
   $this->ref_no,
   $this->description,
   $this->bpartner_id,
   $this->iscomplete,
   $this->bpartneraccounts_id,
   $this->spinvoice_prefix,
   $this->issotrx,
   $this->terms_id,
   $this->contacts_id,
   $this->preparedbyuid,
   $this->salesagentname,
   $this->isprinted,
   $this->localamt,
   $this->address_text,
   $this->branch_id,
   $this->tracking1_id,
   $this->tracking2_id,
   $this->tracking3_id);
    if($save->InsertRecord($this->tablename,   $arrInsertField,
            $arrvalue,$arrInsertFieldType,$this->spinvoice_prefix.$this->document_no,"invoice_id")){
            $this->invoice_id=$save->latestid;
            return true;
            }
    else
            return false;

  }


 public function updateInvoice( ) {

     include include "../simantz/class/Save_Data.inc.php";;
    $save = new Save_Data();
    $arrUpdateField=array(
        "document_no",
    "document_date",
    "batch_id",
    "currency_id",
    "exchangerate",
    "originalamt",
    "updated",
    "updatedby",
    "itemqty",
    "ref_no",
    "description",
    "bpartner_id",
    "iscomplete",
    "bpartneraccounts_id",
    "spinvoice_prefix",
    "terms_id",
    "contacts_id",
    "preparedbyuid",
    "salesagentname",
    "isprinted",
    "localamt",
    "address_text",
    "branch_id",
    "tracking1_id",
    "tracking2_id",
    "tracking3_id");
    $arrUpdateFieldType=array(
        "%d",
    "%s",
    "%d",
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%s",
    "%s",
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%s",
    "%d",
    "%d",
    "%d",
    "%d");
    $arrvalue=array($this->document_no,
   $this->document_date,
   $this->batch_id,
   $this->currency_id,
   $this->exchangerate,
   $this->originalamt,
   $this->updated,
   $this->updatedby,
   $this->itemqty,
   $this->ref_no,
   $this->description,
   $this->bpartner_id,
   $this->iscomplete,
   $this->bpartneraccounts_id,
   $this->spinvoice_prefix,
   $this->terms_id,
   $this->contacts_id,
   $this->preparedbyuid,
   $this->salesagentname,
   $this->isprinted,
   $this->localamt,
   $this->address_text,
   $this->branch_id,
   $this->tracking1_id,
   $this->tracking2_id,
   $this->tracking3_id);

    if( $save->UpdateRecord($this->tablename, "invoice_id",
                $this->invoice_id,
                    $arrUpdateField, $arrvalue,  $arrUpdateFieldType,$this->spinvoice_prefix.$this->document_no))
            return true;
    else
            return false;

  }

  public function deleteInvoice($invoice_id){
include "../simantz/class/Save_Data.inc.php";
$save = new Save_Data();

   if($this->fetchAccounts($invoice_id)){

    return $save->DeleteRecord($this->tablename,"$invoice_id",$invoice_id,$this->spinvoice_prefix.$this->document_no,1);
   }
   else
       return false;

}

public function insertInvoiceLine($subject,$arrvalue){
        include include "../simantz/class/Save_Data.inc.php";;
          $save = new Save_Data();
          $arrInsertField=array(
                "seqno",
                "subject",
                "description",
                "accounts_id",
                "uprice",
                "qty",
                "uom",
                "tax_id",
                "branch_id",
                "track1",
                "track2",
                "track3",
                "amt",
                "invoice_id",
                "gstamt",
                "granttotalamt");
              $arrInsertFieldType=array(
                "%d",
                "%s",
                "%s",
                "%d",
                "%d",
                "%d",
                "%s",
                "%d",
                "%d",
                "%s",
                "%s",
                "%s",
                "%d",
                "%d",
                "%d",
                "%d");

               if($save->InsertRecord($this->tableinvoiceline,   $arrInsertField,
                $arrvalue,$arrInsertFieldType,$subject,"invoiceline_id")){
                 $this->invoiceline_id=$save->latestid;
                 return true;
              }
             else
            return false;
}

public function updateInvoiceLine($subject,$arrvalue,$invoiceline_id){
       include include "../simantz/class/Save_Data.inc.php";;
          $save = new Save_Data();
          $arrUpdateField=array(
                "seqno",
                "subject",
                "description",
                "accounts_id",
                "uprice",
                "qty",
                "uom",
                "tax_id",
                "branch_id",
                "track1",
                "track2",
                "track3",
                "amt",
                "gstamt",
                "granttotalamt");
              $arrUpdateFieldType=array(
                "%d",
                "%s",
                "%s",
                "%d",
                "%d",
                "%d",
                "%s",
                "%d",
                "%d",
                "%s",
                "%s",
                "%s",
                "%d",
                "%d",
                "%d");

   if( $save->UpdateRecord($this->tableinvoiceline, "invoiceline_id",
                $invoiceline_id,
                    $arrUpdateField, $arrvalue,  $arrUpdateFieldType,$subject))
            return true;
             else
            return false;
}
public function deleteInvoiceLine(){}


public function saveGridLine(){
    
    foreach($this->gridvaluearray as $row){
        foreach($this->gridfieldarray as $no => $v){
            $this->log->showLog(4,"$no:".$this->gridfieldarray[$no]."-".$row[$no]);
          if($row['a']==0){ //invoice_id=0

             $arrayfieldforinsert=array(
                $row["b"],
                $row["c"],
                $row["d"],
                $row["e"],
                $row["f"],
                $row["g"],
                $row["h"],
                $row["i"],
                $row["j"],
                $row["k"],
                $row["l"],
                $row["m"],
                $row["n"],
                $row["o"],
                $row["p"],
                $row["q"] );
            if(!$this->insertInvoiceLine($row["c"],$arrayfieldforinsert))
                return false;
          }
          else{
                
             $arrayfieldforupdate=array(
                $row["b"],
                $row["c"],
                $row["d"],
                $row["e"],
                $row["f"],
                $row["g"],
                $row["h"],
                $row["i"],
                $row["j"],
                $row["k"],
                $row["l"],
                $row["m"],
                $row["n"],
                $row["p"],
                $row["q"] );
            if(!$this->updateInvoiceLine($row["c"],$arrayfieldforupdate,  $row["a"]))
                return false;
          }
        }

    }
}
public function validateForm(){
    return true;
}

public function showSearchForm(){
    global $nitobigridthemes;
  return  $xml=<<< _EOF
      <script language="javascript" type="text/javascript">
        jQuery(document).ready((function (){nitobi.loadComponent('searchgrid');}));
    </script>
   <a href='salesinvoice.php'>[Add Invoice]</a>
<form onsubmit='return false'>
   <table>
        <tbody>
            <tr><th colspan='4'>Search Form</th></tr>
            <tr>
                <td>Invoice No From</td>
                <td><input id='document_nofrom'></td>
                <td>Invoice No To</td>
                <td><input id='document_noto'></td>
            </tr>
            </tbody>
   </table>
</form>
<br/>

    <ntb:grid id="searchgrid"
     mode="livescrolling"
     ondatareadyevent="dataready();"
     oncellclickevent="clickrecord(eventArgs)"
     gethandler="salesinvoice.php?action=ajaxsearch"
     theme="$nitobigridthemes"
     rowhighlightenabled="true"
     toolbarenabled="false"
     >
   <ntb:columns>
       <ntb:textcolumn maxlength="3"  label="Races Name"  xdatafld="races_name" ></ntb:textcolumn>
       <ntb:textcolumn label="Description"  width="100"  xdatafld="races_description">
            <ntb:textareaeditor  ></ntb:textareaeditor>
       </ntb:textcolumn>
       <ntb:textcolumn      label="Active"   width="45"  xdatafld="isactive"   sortenabled="false">
             <ntb:checkboxeditor datasource="[{value:'1',display:'Yes'},{value:'0',display:'No'}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value">
            </ntb:checkboxeditor>
       </ntb:textcolumn>
       <ntb:numbercolumn   maxlength="4" label="Default Level"  width="100" xdatafld="defaultlevel" mask="###0"></ntb:numbercolumn>
<ntb:textcolumn  label="Log"   xdatafld="info"    width="50"  sortenabled="false" >
            <ntb:linkeditor></ntb:linkeditor openwindow="true" >
       </ntb:textcolumn>
       <ntb:textcolumn      label="Deleted"   width="50"  xdatafld="isdeleted">
            <ntb:checkboxeditor datasource="[{valuedd:'1',displaydd:'Yes'},{valuedd:'0',displaydd:'No'}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="displaydd" valuefield="valuedd">
           </ntb:checkboxeditor>
       </ntb:textcolumn>
 </ntb:grid>
_EOF;
}


public function gridjs(){

  return  $js= <<< JS
      <script language="javascript" type="text/javascript">
        jQuery(document).ready((function (){nitobi.loadComponent('invoicegrid');}));




        function addLine(){
        var myGrid = nitobi.getGrid('invoicegrid');
        myGrid.insertRow(2);
        }

        function deleteLine(){
        if(confirm('Delete this line? After delete the record is no recoverable.')){
        var myGrid = nitobi.getGrid('invoicegrid');
        myGrid.deleteRow(1);
        }
        }


        function saverecord(){

                document.getElementById("popupmessage").innerHTML="Saving data...";
                popup('popUpDiv');
        	var invoicegrid = nitobi.getGrid('invoicegrid');
                var griddata = invoicegrid.getDataSource().getDataXmlDoc();

                griddata= nitobi.xml.serialize(griddata).replace(/ntb:/g, "");
                griddata=griddata.replace(/:ntb/g,"ntb")
                document.getElementById("gridxml").value=griddata;


                var errordiv=document.getElementById("errormsg");
                errordiv.style.display="none";
                var invoice_id=document.getElementById("invoice_id").value;
                var document_no=document.getElementById("document_no").value;

                var document_date=document.getElementById("document_date").value;
                var originalamt=document.getElementById("originalamt").value;
                var currency_id=document.getElementById("currency_id").value;
                var exchangerate=document.getElementById("exchangerate").value;
                var originalamt=document.getElementById("originalamt").value;
                var ref_no=document.getElementById("ref_no").value;
                var description=document.getElementById("description").value;
                var bpartner_id=document.getElementById("bpartner_id").value;
                var iscomplete=document.getElementById("iscomplete").value;
                var spinvoice_prefix=document.getElementById("spinvoice_prefix").value;
                var terms_id=document.getElementById("terms_id").value;
                var contacts_id=document.getElementById("contacts_id").value;
                var preparedbyuid=document.getElementById("preparedbyuid").value;
                var salesagentname=document.getElementById("salesagentname").value;
                var localamt=document.getElementById("localamt").value;
                var address_text=document.getElementById("address_text").value;
                var tracking1_id=document.getElementById("tracking1_id").value;
                var tracking2_id=document.getElementById("tracking2_id").value;
                var tracking3_id=document.getElementById("tracking3_id").value;
                var note=document.getElementById("note").value;


            var data="action="+"ajaxsave"+
                    "&invoice_id="+invoice_id+
                    "&document_no="+document_no+
                    "&document_date="+document_date+
                    "&originalamt="+originalamt+
                    "&currency_id="+currency_id+
                    "&exchangerate="+exchangerate+
                    "&originalamt="+originalamt+
                    "&ref_no="+ref_no+
                    "&description="+description+
                    "&bpartner_id="+bpartner_id+
                    "&iscomplete="+iscomplete+
                    "&spinvoice_prefix="+spinvoice_prefix+
                    "&terms_id="+terms_id+
                    "&contacts_id="+contacts_id+
                    "&preparedbyuid="+preparedbyuid+
                    "&salesagentname="+salesagentname+
                    "&localamt="+localamt+
                    "&address_text="+address_text+
                    "&tracking1_id="+tracking1_id+
                    "&tracking2_id="+tracking2_id+
                    "&tracking3_id="+tracking3_id+
                    "&note="+note+
                    "&griddata="+griddata;

            $.ajax({
                 url: "salesinvoice.php",type: "POST",data: data,cache: false,
                     success: function (xml) {

                     var status=$(xml).find("status").text();

                     if(status==1){
                       errordiv.style.display="none";

                              if(invoice_id==0){
                                    document.getElementById("invoice_id").value=$(xml).find("invoice_id").text();

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

         function deleterecord(){

          if(confirm('Delete this record?')){
           var invoice_id=document.getElementById("invoice_id").value;
            var data="action=ajaxdelete&invoice_id="+invoice_id;
            $.ajax({
                 url: "accounts.php",type: "POST",data: data,cache: false,
                     success: function (xml) {
                       alert("Record deleted, please proceed to add new record.");
                    }});
          }
        }

        function onclickcell(eventArgs){
          var  myGrid = nitobi.getGrid('invoicegrid');
          var  row = eventArgs.cell.getRow();
          var col = eventArgs.cell.getColumn();
          var myCell = myGrid.getCellObject(row, col);
          myCell.edit();
        }
        </script>
JS;
}


public function showSearchGridContent(){
       global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    
 
    $searchisdeleted=$_GET['searchisdeleted'];

    $sortcolumn="concat(spinvoice_prefix,document_no)";
    $sortdirection="ASC";

    $this->log->showLog(2,"Access showSearchGridContent($wherestring)");
   
    $wherestring=" WHERE issotrx=1 and documenttype=1 ";
$newQuery = "SELECT  invoice_id, concat(spinvoice_prefix,document_no) as document_no,ref_no, document_date,
        bpartner_id,terms_id, currency_id, originalamt,
         iscomplete,isprinted
            FROM $this->tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $this->log->showLog(4,"With SQL: $newQuery");
        $query = $this->xoopsDB->query($newQuery);

         $getHandler->ProcessRecords();
        $getHandler->DefineField("invoice_id");
     	$getHandler->DefineField("document_no");
        $getHandler->DefineField("ref_no");
        $getHandler->DefineField("document_date");
        $getHandler->DefineField("bpartner_id");
        $getHandler->DefineField("parentwindows_id");
     	$getHandler->DefineField("terms_id");
        $getHandler->DefineField("currency_id");
        $getHandler->DefineField("originalamt");
        $getHandler->DefineField("iscomplete");
        $getHandler->DefineField("isprinted");
	$currentRecord = 0; // This will assist us finding the ordinalStart position

      while ($row=$this->xoopsDB->fetchArray($query))
     {
                    $this->log->showLog(4,"SQL OK");

     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['window_id']);
             $getHandler->DefineRecordFieldValue("window_name", $row['window_name']);
             $getHandler->DefineRecordFieldValue("filename", $row['filename']);
             $getHandler->DefineRecordFieldValue("description", $row['description']);
             $getHandler->DefineRecordFieldValue("windowsetting", $row['windowsetting']);
             $getHandler->DefineRecordFieldValue("parentwindows_id", $row['parentwindows_id']);
             $getHandler->DefineRecordFieldValue("mid", $row['mid']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("isdeleted",$row['isdeleted']);
             $getHandler->DefineRecordFieldValue("info","../recordinfo.php?id=".$row['window_id']."&tablename=sim_window&idname=window_id&title=Window");
             $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
        $this->log->showLog(2,"complete ShowWindow()");
}
}

?>


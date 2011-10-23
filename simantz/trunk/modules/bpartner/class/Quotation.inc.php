<?php

class Quotation {

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
    public $bpartneraccounts_id;
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
    public $saleagent_name;
    public $saleagent_id;
    public $usedBpartnerType;

    public function Quotation() {
        global $xoopsDB, $log, $tablequotation, $tablequotationline, $defaultorganization_id;
        $tablequotation="sim_bpartner_quotation";
        $this->xoopsDB = $xoopsDB;
        $this->organization_id = $defaultorganization_id;
        $this->log = $log;
        $this->tableorganization = $tableorganization;
        $this->tablecurrency = $tablecurrency;
        $this->tablequotation = $tablequotation;
        $this->tablequotationline = $tablequotationline;
        $this->tablename = $tablequotation;
        $this->usedBpartnerType = "creditor"; // option {creditor, debtor} effect in autocomplete

        $this->log->showLog(3, "Access Quotation()");
    }

    public function showCreateForm() {
         $nextno = $this->getNextNo();
        
        global $bpctrl, $userid, $havewriteperm,$spquotation_prefix;


        $currencyoption = $bpctrl->getSelectCurrency(0, "N");
        $date = date("Y-m-d", time());

        
            $title = 'Sales Quotation';
			
        $this->defineHeaderButton();
        include "../simantz/class/FormElement.php";
        include "../bpartner/class/BPartnerFormElement.inc.php";
        $fe = new FormElement();
        $sbfe = new BPartnerFormElement();
        $sbfe->activateAutoComplete();
        $bpbox = $sbfe->getBPartnerBox(0, '', 'bpartner_id', 'bpartner_id', '350px', 'onchange="chooseBPartner()"');
//        $agentbox = $sbfe->getAgentBox(0, '', 'saleagent_id', 'saleagent_id', '150px');
        $uidoption = $bpctrl->getSelectUsers($userid);
        if ($havewriteperm == 1)
            $savebutton = "<input  id='nextbutton' name='submit' onclick='return saveform()' type='submit' value='Create'/>
<input type='hidden' name='action' value='create'>";
        else
            $savebutton = "";
        echo <<< EOF
<script>



$(function() {
	});

	    function zoomBPartner(){
			var bpartner_id=document.getElementById("bpartner_id").value;
          if(bpartner_id>0)
           window.open("../bpartner/bpartner.php?action=viewsummary&bpartner_id="+bpartner_id,"_blank");
          else
          alert("You need to choose business partner!");
          }
       function chooseBPartner(){
              var bpid=document.getElementById("bpartner_id").value;
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
                               var bpartneraccounts_id=$(xml).find("bpartneraccounts_id").text();
								
                              
                                $("#address_id").html(address);
                                $("#contacts_id").html(contact);
                                $("#terms_id").html(terms);
                                $("#currency_id").html(currency);
                                //document.getElementById("salesagentname").value=salesagent;
 //                               document.getElementById("bpartneraccounts_id").value=bpartneraccounts_id;
//                                comparecurrency();
                                
									if(document.getElementById('address_text'))
										updateAddressText();
								
								
								var limitamt=parseFloat($(xml).find("limitamt").text());
                                var usage=parseFloat($(xml).find("usage").text());
                                var control=$(xml).find("control").text();

								var iscontrol="";
								if(control=='1')
											iscontrol="Y";
									else
										iscontrol="N";
								$("#divlimit").html("Credit Limit:"+limitamt+",Current Usage:"+usage+":Control Limit:"+iscontrol);
								
								if(iscontrol=='Y' && usage>limitamt){
									alert("Warning! Current usage is bigger than credit limit!");
									}
								}
                           });



        }
                 
     function saveform(){
		 if(confirm("Confirm create $title?")){
			 
			if($("#bpartner_id").val()==0){
					$("#bpartner_id_text").addClass("red");
				alert("Please choose appropriate business partner!");
				return false;
				}
			else
				$("#bpartner_id_text").removeClass("red");
					
				
			$("#frmQuotation").submit();
			return true;
			
		}
		 else
			return false;
		 }
		 
     
</script>
<div align=center>
  <table style="width:990px;text-align: left; " >
        <tr><td align="left">$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr>
  </table>
<form method='post' name='frmQuotation' id='frmQuotation'  action='$this->quotationfilename'  enctype="multipart/form-data">
   <table style="text-align: left; width: 990px;" border="0" cellpadding="0" cellspacing="1"  class="searchformblock">
    <tbody>

      <tr>
        <td colspan="4" rowspan="1" align="center" id="idHeaderText" class="searchformheader" >New $title</td>
      </tr>

      <tr>
        <td class="head">Date (YYYY-MM-DD)</td>
        <td class="even">
            <input id='document_date' name='document_date'  size='12'  value='$date' class='datepick'>
            </td>
        <td class="head">Document No</td>
        <td class="even">
					<input name='spquotation_prefix' id='spquotation_prefix' value='$spquotation_prefix'size='4'>
                         <input name='document_no' id='document_no'  value='<<NEW>>' size='12'> Next No: $nextno
                         </td>
      </tr>
      <tr> 
        <td class="head">Business Partner</td>
			<td class="even">$bpbox<img style="cursor:pointer" onclick=zoomBPartner() src="../simantz/images/zoom.png">
			<input name='bpartneraccounts_id' id='bpartneraccounts_id' type='hidden' value=0><div id='divlimit'></div></td>
        <td class="head">Ref. No</td>
        <td class="even"><input id='ref_no' size='20' name='ref_no' value='$this->ref_no'></td>
      </tr>
      <tr>
        <td class="head">Billing Address</td>
			<td class="even"><Select id='address_id' name='address_id'><option value=0>Null</option></Select></td>
        <td class="head">Terms</td>
        <td class="even"> <select id='terms_id' name='terms_id'><option value=0>Null</option></select></td>
      </tr>
      <tr>
        <td class="head">Currency</td>
        <td class="even"> <select id='currency_id' name='currency_id'><option value=0>Null</option></select></td>
        <td class="head">Attn To</td>
        <td class="even"> <select id='contacts_id' name='contacts_id'><option value=0>Null</option></select></td>
      </tr>
      <tr>
         <td class="head">Prepared By</td>
         <td class="even"><select id='preparedbyuid' name='preparedbyuid'>$uidoption</select></td>
        <td class="head">Sales Agent</td>
        <td class="even"><input name='salesagentname' id='salesagentname' value=''></td>
      </tr>
      
</table>
$savebutton
</form>
</div>
EOF;
    }

    public function getNextNo() {

        $sql = "SELECT MAX(document_no)  as newno from $this->tablequotation where issotrx=$this->issotrx ";
        $this->log->showLog(3, "Checking next no: $sql");

        $query = $this->xoopsDB->query($sql);

        if ($row = $this->xoopsDB->fetchArray($query)) {
            $newno = $row['newno'];
            $this->log->showLog(3, "Found next newno:$newno");

            if ($newno == "")
                return 1;
            else {
                //0040001
                
                $newno++;
                return $newno;
            }
        }
        else
            return 1;
    }

    public function editJS() {
        global $defaultcurrency_id, $bpctrl,$defaultorganization_id;
        //$taxctrl = $bpctrl->getSelectTax(0, "N");
        //$taxctrl = str_replace("'", '"', $taxctrl);
        global $menuname;
        $link = $this->quotationfilename;

        echo <<<EOF
<script>
        function chooseBPartner(){
              var bpid=document.getElementById("bpartner_id").value;
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
                               var bpartneraccounts_id=$(xml).find("bpartneraccounts_id").text();

                                $("#address_id").html(address);
                                $("#contacts_id").html(contact);
                                $("#terms_id").html(terms);
                                $("#currency_id").html(currency);
                                //document.getElementById("salesagentname").value=salesagent;
                                document.getElementById("bpartneraccounts_id").value=bpartneraccounts_id;
//                                comparecurrency();
                                
									if(document.getElementById('address_text'))
										updateAddressText();
                
						var limitamt=parseFloat($(xml).find("limitamt").text());
                                var usage=parseFloat($(xml).find("usage").text());
                                var control=$(xml).find("control").text();

								var iscontrol="";
								if(control=='1')
											iscontrol="Y";
									else
										iscontrol="N";
									$("#divlimit").html("Credit Limit:"+limitamt+",Current Usage:"+usage+":Control Limit:"+iscontrol);

								
								if(iscontrol=='Y' && usage>limitamt){
									alert("Warning! Current usage is bigger than credit limit!");
									}
                             }
                           });



        }



        function comparecurrency(){
            var currency_id=document.getElementById("currency_id").value;

            if(currency_id==$defaultcurrency_id){
               document.getElementById("exchangerate").value=1;
               updateamount();
            }else{
               var data="action=getcurrency&currency_id="+currency_id;
               $.ajax({url:"$this->quotationfilename",type: "POST",data: data,cache: false,
                success: function (xml){
                     jsonObj = eval( '(' + xml + ')');
                     var currency_rate = jsonObj.currency_rate;
                     document.getElementById("exchangerate").value=currency_rate;
                     updateamount();
                }}); 
  
            }
        
          }

        function updateAddressText(){
            var checkaddresstext="action=checkaddresstext&address_id="+document.getElementById("address_id").value;
                                 $.ajax({url:"$this->quotationfilename",type: "POST",data: checkaddresstext,cache: false,
                                    success: function (ad){

                                        document.getElementById("address_text").value=ad;
                                        }
                                });
          }

		
		function showDesc(line){
			$('#description_'+line).toggle("fast");
			}
			

		function deleteline(il_id,lineno){

			    //
		if(confirm("Delete this line?")){
			if(il_id>0){
				  var data ="action=deleteline&quotationline_id="+il_id;
                 $.ajax({url: "$this->quotationfilename",type: "POST",data: data,cache: false,
                     success: function (xml) {
						 
                     jsonObj = eval( '(' + xml + ')');
				$("#trline_"+lineno).remove();
				
						saverecord(0,false);
				 }});
			}
			else{
				$("#trline_"+lineno).remove();
				updateamount(0);
				}
		}
			else
			return false;
		}
		
		function viewlinehistory(il_id){
			//tablename=sim_country&idname=country_id&title=Country
			window.open("../simantz/recordinfo.php?tablename=sim_bpartner_quotationline&idname=quotationline_id&title=$menuname&id="+il_id);
			}

		function viewhistory(){
			
			window.open("../simantz/recordinfo.php?tablename=sim_bpartner_quotation&idname=quotation_id&title=$menuname&id=$this->quotation_id");

			}

        function addLine(){
			
                totalline=$("#totalline").val();
				$("#totalline").val(parseInt($("#totalline").val())+1);
	

				
            $('#trlinetotal')
                .before('<tr id="trline_'+totalline+'">'+
                        '<td class="" style="vertical-align:top;"><input type="text" size="3" value="'+(totalline*10)+'" name="lineseqno['+totalline+']" id="lineseqno_'+totalline+'"></td>'+
                        '<td class=""><input type="hidden" value="0" name="linequotationline_id['+totalline+']" id="quotationline_id_'+totalline+'">'+
                                     '<input type="text" style="width:350px" size="60" value="$subject" name="linesubject['+totalline+']" id="subject_'+totalline+'">'+
                                     '<small style="color:red; cursor: pointer" onclick=showDesc('+totalline+')>[+]Remark</small>'+
                                     '<textarea name="linedescription['+totalline+']"  rows="8" style=" width:450px; display:none" id="description_'+totalline+'" ></textarea></td>'+


                       '<td class=""><input style="width:70px;text-align:right"  value="0.00" id="unitprice_'+totalline+'" name="lineunitprice['+totalline+']" onfocus="this.select()"  onchange="updateamount()"></td>'+
                        '<td class=""><input style="width:50px;text-align:right" value="1" id="qty_'+totalline+'" name="lineqty['+totalline+']" onfocus="this.select()" onchange="updateamount()"></td>'+
                        '<td class=""><input type="text" style="width:50px;text-align:right" value="Unit" id="uom_'+totalline+'" name="lineuom['+totalline+']" onfocus="this.select()"></td>'+
                        '<td class="">'+
							'<input value="0.00"  readonly="readonly" id="amt_'+totalline+'" name="lineamt['+totalline+']"  style="width:70px;text-align:right"></td>'+
					'<td class="" style="text-align:center;"><img src="../simantz/images/del.gif" style="cursor: pointer" onclick=deleteline(0,'+totalline+')></td>'+
                    '<td class="" style="text-align:center;"></td>'+
                    '</tr>'
                      );
        
        activateAutoComplete();
        }



    function viewlog(){
    }


  function previewQuotation(){
	  
                window.open("$this->quotationfilename?action=pdf&quotation_id="+document.getElementById("quotation_id").value)
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
    function zoomBPartner(){
			var bpartner_id=document.getElementById("bpartner_id").value;
          if(bpartner_id>0)
           window.open ("../bpartner/bpartner.php?action=viewsummary&bpartner_id="+bpartner_id,"_blank");
          else
          alert("You need to choose business partner!");
          }


	function updateamount(){

             var totalline=parseInt( $("#totalline").val());
             var exchangerate=parseFloat( $("#exchangerate").val());
		
              var total=0;
				var amt=0;
				var total=0;
				var localamt=0;
				var subtotal=0;

				var granttotalamt=0;
              for( var i = 0; i < totalline; i++ ) {
				  
					if(document.getElementById('qty_'+i)){
                    var qty = parseFloat($("#qty_"+i).val());
					}
					if(document.getElementById('unitprice_'+i))
                    var unitprice = parseFloat($("#unitprice_"+i).val());


 					amt=qty*unitprice;
    				localamt=amt* exchangerate;

					total=(qty*unitprice);
                   
					if(document.getElementById('amt_'+i))
                    $("#amt_"+i).val(amt.toFixed(2));
					
					if(document.getElementById('localamt_'+i))
                    $("#localamt_"+i).val(localamt.toFixed(2));
					
                    
					if(document.getElementById('granttotalamt_'+i))
                    $("#granttotalamt_"+i).val(total.toFixed(2));
					
					if(document.getElementById('localgranttotalamt_'+i))
                    $("#localgranttotalamt_"+i).val((total*exchangerate).toFixed(2));
					if(document.getElementById('amt_'+i)){
					subtotal+=amt;
					granttotalamt+=total;
					
					}
              }
              //subtotal
              document.getElementById("subtotal").value=subtotal.toFixed(2);
              
              
              }
        
     function comparecurrency(){
            var currency_id=document.getElementById("currency_id").value;

            if(currency_id==$defaultcurrency_id){
               document.getElementById("exchangerate").value=1;
               updateCurrency();
            }else{
               var data="action=getcurrency&currency_id="+currency_id;
               $.ajax({url:"$this->quotationfilename",type: "POST",data: data,cache: false,
                success: function (xml){
                     jsonObj = eval( '(' + xml + ')');
                     var currency_rate = jsonObj.currency_rate;
                     document.getElementById("exchangerate").value=currency_rate;
                     updateCurrency();
                }}); 
  
            }
        
          }


$(document).ready(function(){
	
	if($("#totalline").val()=='0')
	addLine();
	});

  function saverecord(iscomplete,askconfirmation){
          var bpartner_id=document.getElementById("bpartner_id").value;
          var quotation_id=document.getElementById("quotation_id").value;
                
          if(!validation())
          return false;

          var iscompletectrl=document.getElementById("iscomplete");
              iscompletectrl.value=iscomplete;
		var msg='';

          if(iscompletectrl.value==1){
             var msg="Confirm Complete the record?";
          }else{
              var msg="Confirm Save the record?";

		}

		
		if(askconfirmation==false) 
		var confirmsave=true;
		else
		var confirmsave=confirm(msg);
          if(confirmsave){

                var exchangerate=document.getElementById("exchangerate").value;
                var quotation_id=document.getElementById("quotation_id").value;
                var errordiv=document.getElementById("errormsg");
                errordiv.style.display="none";

                 var data =$("#frmQuotation").serialize();
                 $.ajax({url: "$this->quotationfilename",type: "POST",data: data,cache: false,
                     success: function (xml) {
                     jsonObj = eval( '(' + xml + ')');
                     var status = jsonObj.status;
					
                     if(status==1){
						 
						var datast="action=refreshsubtable&quotation_id=$this->quotation_id";
						
                 $.ajax({url: "$this->quotationfilename",type: "POST",data: datast,cache: false,
                     success: function (stxml) {
						 
						 $("#subtable").html("no data");
						 $("#subtable").html(stxml);
								activateAutoComplete();

						 }});
						 
			
                
					if(iscomplete==1)
						window.location="$this->quotationfilename?action=view&quotation_id=$this->quotation_id";

                     }else if(status==0){
                            errordiv.style.display="";
                            errordiv.innerHTML="Cannot save record due to internal error"+xml; 
                     }else
                         alert("unknown status");

                   }});
                }
             
        }
        
         function validation(){
           var bpartner_id=document.getElementById("bpartner_id").value;          
           var currency_id=document.getElementById("currency_id").value;
           var docdate=document.getElementById("document_date").value;
        
           if(docdate=="" || !isDate(docdate)){
              alert("Please insert appropriate date");
              return false;
           }

           if(currency_id==0 || currency_id ==""){
              alert("Please insert appropriate currency!");
              return false;
           }

        
           return true;
        }
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



     function posting(){

          var data="action=posting&quotation_id="+document.getElementById("quotation_id").value;
          $.ajax({url:"$this->quotationfilename",type: "POST",data: data,cache: false,
                  success: function(xml){
                  if(xml!= ""){
                     jsonObj = eval( '(' + xml + ')');
                     var status = jsonObj.status;
                     if(status==1){
                        window.location="$this->quotationfilename?action=view&quotation_id="+document.getElementById("quotation_id").value;
                     }else
                         alert("cannot post record, please check you financial year, businss partner setting, and make sure exchange rate and local total >0");
                 }
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

</script>
EOF;
    }

    public function insertQuotation() {
		global $defaultorganization_id;
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
        if($this->document_no=='<<NEW>>')	
        $this->document_no=$this->getNextNo();
    $arrvalue=array($this->document_no,
   $defaultorganization_id,
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

    public function getMultiplyValue() {

        if ($this->issotrx == 1 && $this->documenttype == "I")
            $multiply = 1;
        elseif ($this->issotrx == 0 && $this->documenttype == "I")
            $multiply = -1;
        elseif ($this->issotrx == 1 && $this->documenttype == "D")
            $multiply = 1;
        elseif ($this->issotrx == 1 && $this->documenttype == "C")
            $multiply = -1;
        elseif ($this->issotrx == 0 && $this->documenttype == "D")
            $multiply = 1;
        elseif ($this->issotrx == 0 && $this->documenttype == "C")
            $multiply = -1;


        return $multiply;
    }

    public function GetCurrency() {
        global $defaultcurrency_id;
        $end = "9999-12-30";
        $currentday = date("Y-m-d", time());

        $sql = sprintf("SELECT amountrate from sim_currencyline WHERE fromcurrency_id = '%d'
                      AND tocurrency_id = '%d' AND datefrom=(SELECT MAX(datefrom) FROM sim_currencyline WHERE fromcurrency_id = '%d'
                      AND tocurrency_id = '%d');", $this->currency_id, $defaultcurrency_id, $this->currency_id, $defaultcurrency_id);
        $this->log->showLog(3, 'Get AmountRate');
        $this->log->showLog(4, "SQL: $sql");
        $query = $this->xoopsDB->query($sql);
        if ($this->convertto_id == $defaultcurrency_id) {
            $this->currency_rate = 1;
        } else {
            if ($row = $this->xoopsDB->fetchArray($query)) {
                $this->currency_rate = $row['amountrate'];
            } else {
                $this->currency_rate = 0;
            }
        }
    }

    public function getInputForm($type="") {

        global $userid, $bpctrl, $ctrl, $defaultorganization_id, $havewriteperm, $sbfe;
        $this->log->showLog(3, "Access Quotation getInputForm()");

        $bpbox = $sbfe->getBPartnerBox($this->bpartner_id, "$this->bpartner_no - $this->bpartner_name", 'bpartner_id', 'bpartner_id', '350px', 'onchange="chooseBPartner()"', $this->usedBpartnerType);
      //  $agentbox = $sbfe->getAgentBox($this->saleagent_id, "$this->saleagent_no - $this->saleagent_name", 'saleagent_id', 'saleagent_id', '150px');
        $uidoption = $bpctrl->getSelectUsers($userid);



      
        $tableheader = "Edit Quotation";
        //include_once "../simantz/class/SelectCtrl.inc.php";
        //$ctrl = new SelectCtrl();
        include_once "../bpartner/class/BPSelectCtrl.inc.php";
        $bpctrl = new BPSelectCtrl();
        include_once "../bpartner/class/BPartner.php";
        $bp = new BPartner();

        $bpartner_id = $_REQUEST['bpartner_id'];
        $bp->fetchBpartnerData($bpartner_id);
//           $voidctrl = "<input type='button' value='Void' id='btnvoid' onclick=javascript:voidQuotation()>";
        $addressxml = $bpctrl->getSelectAddress($this->address_id, "N", $this->bpartner_id);
        $termsxml = $bpctrl->getSelectTerms($this->terms_id, "N");
        $contactxml = $bpctrl->getSelectContacts($this->contacts_id, 'N', "", "", " and bpartner_id=$this->bpartner_id");
        $currencyxml = $ctrl->getSelectCurrency($this->currency_id);
        $branchctrl = $ctrl->selectionOrganization($userid, $this->organization_id);

        $attnoption = $contactxml;
        $uidoption = $ctrl->getSelectUsers($this->preparedbyuid);
        $termsoption = $termsxml;
        $addressoption = $addressxml;
        $currencyoption = $currencyxml;
        // $branchoption="<option value='1'>HQ</option>";
        //   $grid = $this->getGrid($this->quotation_id);
        if ($this->issotrx == 1)
            $bpartnertype = "isdebtor";
        else
            $bpartnertype = "iscreditor";

   if($havewriteperm==1)  
		$savebutton="<input type='button' name='save' onclick='saverecord(0,true)'id='submit' value='Save'/>
        <input type='button' name='complete' onclick='saverecord(1,true);' id='submit' value='Complete'/>
        <input type='button' name='save' onclick='deleterecord()' type='submit' id='delete' value='Delete'/>
        <input name='action' id='action' value='update'  type='hidden'/>
        <input type='button' id='preview' value='Preview' onclick='javascript:previewQuotation()'/>
	<input type='button' id='btnviewhistory' name='btnviewhistory' onclick='viewhistory()' value='View Record Info'/>";
        else
            $savebutton = "
        <input type='button' value='Preview' onclick='javascript:previewQuotation()'>
        <input type='button'  id='btnviewhistory' value='View Record Info' name='btnviewhistory' onclick='viewhistory()'/>	
";
        $this->defineHeaderButton();
        $subtable = $this->subtable();
        $html = <<< HTML
<div id="idApprovalWindows" style="display:none"></div>
  
<div id='centercontainer'>
 <div align="center" >
  <table style="width:990px;text-align: left; " >
        <tr><td align="left">$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr>
  </table>
                $noperm
 <div id='errormsg' class='red' style='display:none'></div>
<form onsubmit='return false' method='post' name='frmQuotation' id='frmQuotation'  action='$this->quotationfilename'  enctype="multipart/form-data">
   <table style="text-align: left; width: 990px;" border="0" cellpadding="0" cellspacing="1"  class="searchformblock">
    <tbody>
        <tr>
        <td colspan="4" rowspan="1" align="center" id="idHeaderText" class="searchformheader" >$tableheader</td>
        </tr>
        <tr>
          <td class="head">$document</td>
          <td class="even"><input name='spquotation_prefix' id='spquotation_prefix' value='$this->spquotation_prefix'size='3'>
                            <input name='document_no' id='document_no'  value='$this->document_no' size='10'>
                    </td>


            <td class="head">Business Partner</td>
          <td class="even">$bpbox<img src="../simantz/images/zoom.png" style="cursor:pointer" onclick=zoomBPartner()></a>
          <div id='divlimit' style='float:left'></div>
          </td>
     </tr>
     <tr>
        <td class="head">Date (YYYY-MM-DD)</td>
          <td class="even">
            <input id='document_date' name='document_date' class='datepick'  size='12'  value='$this->document_date'>
          <td class="head">Attn To </td>
          <td class="even"><select id='contacts_id' name='contacts_id' >$attnoption</select></td>
     </tr>
     <tr>
      <td class="head">Terms</td>
      <td class="even"><select id='terms_id' name='terms_id'>$termsoption</select></td>
      <td class="head">$refno</td>
      <td class="even"><input id='ref_no' size='20' name='ref_no' value='$this->ref_no'></td>
     </tr>
     <tr>
         <td class="head">Prepared By</td>
         <td class="even"><select id='preparedbyuid' name='preparedbyuid'>$uidoption</select></td>
        <td class="head">Sales Agent</td>
         <td class="even">

          
          
                <input id='salesagentname'  name='salesagentname' value='$this->salesagentname'>
                
         </td>
</tr>
            
<tr>
       <td class="head">Address</td>
       <td class="even"><select id='address_id' name='address_id' onchange=updateAddressText()>$addressoption</select><br/>
        <textarea id='address_text' name='address_text' cols='50' rows='3'>$this->address_text</textarea>
        </td>
         <td class="head">Currency</td>
          <td class="even">
                    <select id='currency_id' name='currency_id' onchange=comparecurrency()>$currencyoption</select> Exchange rate: MYR<input size='8' id='exchangerate' onchange=updateamount() value="$this->exchangerate" name="exchangerate"><br/>
     </td>
<tr><td colspan='4'>
                
    <div id='subtable'>
$subtable           </div>
<br>
           <div style="width:960px;align:right;text-align:right;">
        <input name='quotation_id' id='quotation_id'  value='$this->quotation_id'  title='quotation_id' type='hidden'>
        <input name='iscomplete'  id='iscomplete' value='$this->iscomplete'  title='iscomplete' type='hidden'>
                $savebutton

            </div>
</div>
</td></tr>
 <td class="head">Description</td>
<td class="even" colspan='2'><textarea cols='70' rows='3' id='description'  name='description'>$this->description</textarea>
             <div id="temp" $display><a onclick="openWindowTemp()" style='cursor:pointer'><u>Browse Template<u></a>
          <a onclick="openWindowsaveTemp()" style='cursor:pointer'><u>Save Template<u></a></div>
            </td>
</tr><tr>
   <td class="head">Note</td>
<td class="even" colspan='2'><textarea cols='70' rows='3' id='note'  name='note'>$this->note</textarea></td>
</tr></table>
</form>
HTML;
        return $html;
    }

    public function isNumberExist() {

        if ($this->document_no == "")
            $this->document_no = 0;

        $sql = "SELECT count(*)  as qty FROM $this->tablename where document_no ='$this->document_no' and spquotation_prefix='$this->spquotation_prefix'";
        $query = $this->xoopsDB->query($sql);

        while ($row = $this->xoopsDB->fetchArray($query)) {
            $this->log->showLog(3, "document no: $this->spquotation_prefix $this->document_no exist, check with sql: $sql");
            if ($row['qty'] > 0)
                return true;
            else
                return false;
        }
        $this->log->showLog(3, "document no: $this->spquotation_prefix $this->document_no not exist, check with sql: $sql");

        return false;
    }

    public function fetchQuotation($quotation_id) {
     
     $this->log->showLog(3,"Access fetchQuotation($quotation_id)");
      $sql="SELECT i.*,bp.bpartner_name, bp.bpartner_no,o.organization_code,
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
         $this->bpartner_no=htmlspecialchars($row['bpartner_no']);
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

    public function subtable() {
        global $havewriteperm, $defcurrencycode, $userid, $sbfe;
        include_once "../simantz/class/SelectCtrl.inc.php";
        include_once "../bparnter/class/BPartnerSelectCtrl.inc.php";
     //   $ctrl = new SelectCtrl();
       // $bpctrl = new BPartnerSelectCtrl();

        $form = "";
        $i = 0;
//second table
        $sql = "SELECT ql.*
                FROM sim_bpartner_quotationline ql
                INNER JOIN sim_bpartner_quotation q ON q.quotation_id=ql.quotation_id
                 WHERE ql.quotation_id=$this->quotation_id order by ql.seqno ASC";

        $this->log->showLog(4, "getsubtalbe :" . $sql . "<br>");
        $query = $this->xoopsDB->query($sql);

        $form .=<<< EOF



<div align="center">


<table id="quotationline" class="" style="width:100%">

   <tr class="searchformheader" >
     <td colspan="8">
       <table><tr><td>
              <div style="float:left;cursor:pointer"><a onclick="addLine()">[Add Line]</a></div>
              <div style="float:center">Item(s)</div>
       </td></tr></table>
     </td>
   </tr>

   <tr class="searchformheader" >
          <td style="width:30px;vertical-align:top;">Seq</td>
          <td style="width:450px">Subject</td>
          <td style="width:50px">Unit Price</td>
          <td style="width:50px">Qty</td>
          <td style="width:70px">UOM</td>

          <td style="width:50px">Amount</td>
          <td>Del</td>
          <td>Log</td>
    </tr>

EOF;
        $g = 0;
        $totalgeneralamt = 0;
        global $sbfe;

        while ($row = $this->xoopsDB->fetchArray($query)) {
            if ($rowtype == "odd")
                $rowtype = "even";
            else
                $rowtype = "odd";
            $subject = htmlspecialchars($row['subject']);
            $description = htmlspecialchars($row['description']);
            if ($description == '')
                $hidedesc = " style='display:none;width:450px' ";
            else
                $hidedesc = " style='width:450px' ";

            $amt = $row['amt'];
            $localamt = $row['localamt'];
            $totalgeneralamt+=$amt;
            $quotationline_id = $row['quotationline_id'];
            $accounts_id = $row['accounts_id'];
            $terms_id = $row['terms_id'];
            $terms_name = $row['terms_name'];
            $quotation_amt = $row['quotation_amt'];
            $unitprice = $row['unitprice'];

            $qty = $row['qty'];
            $uom = $row['uom'];
            $gstamt = $row['gstamt'];
            $granttotalamt = $row['granttotalamt'];
            $localgranttotalamt = $row['localgranttotalamt'];
            $localamt = $row['localamt'];
            $accounts_name = $row['accountcode_full'] . " - " . $row['accounts_name'];
            
          //  $tax = $row['total_tax'] * 0.01;
//name="lineaccount_id[$i]" id="account_id_$i"
//<select name="lineaccount_id[$i]" id="account_id_$i" onfocus=getList(this.id,this.value) style='width:300px'>$acclist</select><img onclick='clearlist()' src='../simantz/images/reload.gif' title='reload'/>
//			$acclist=$bpctrl->getSimpleSelectAccounts($accounts_id,'Y',"and accounts_id=$accounts_id");
            $seqno = $row['seqno'];
            $form .=<<< EOF
         <tr class="$rowtype" id='trline_$i'>
            <td class="$rowtype" style='vertical-align:top;'><input name='lineseqno[$i]' size='3' value='$seqno' id='lineseqno_$i'></td>
            <td >
                                 <input type="hidden" value="$quotationline_id" name="linequotationline_id[$i]" id="quotationline_id_$i">
                                 <input type="text" style="width:350px"  value="$subject" name="linesubject[$i]" id="subject_$i"><small style='color:red; cursor: pointer'  onclick='showDesc($i)'>[+]Remark</small>
                                 <textarea id='description_$i' rows='8' name='linedescription[$i]' $hidedesc>$description</textarea>
            </td>
            <td style='vertical-align:top;'><input style="width:70px;text-align:right" name='lineunitprice[$i]' id='unitprice_$i' value='$unitprice' onchange='updateamount()'></td>
            <td style='vertical-align:top;'><input name='lineqty[$i]' style="width:50px;text-align:right" id='qty_$i' value='$qty' onchange='updateamount()'></td>
            <td style='vertical-align:top;'><input style="width:50px;text-align:right" name='lineuom[$i]' id='uom_$i' value='$uom' ></td>
			<td  style='vertical-align:top;'>
						<input style="width:70px;text-align:right" readonly="readonly" type="text" value="$amt" id="amt_$i" name="lineamt[$i]" >
				</td>
            <td  style="text-align:center;vertical-align:top;"><img src="../simantz/images/del.gif" style="cursor: pointer" onclick=deleteline($quotationline_id,$i)></td>
            <td  style="text-align:center;vertical-align:top;"><img src="../simantz/images/history.gif" style="cursor: pointer" onclick=viewlinehistory($quotationline_id)></td>
         </tr>

EOF;
            $i++;
            $g++;
        }

        $totalgeneralamt = number_format($totalgeneralamt, "2", ".", "");
        $form .=<<< EOF
<tfooter>
         <tr class="foot" id="trlinetotal">
            <td  ></td>
         
            <td  ></td>
            <td >
                                 <input type="hidden" value="$i" name="totalline" id="totalline">
            </td>
            <td  colspan='2'>Sub Total $this->currency_code:</td>
            <td  style="width:60px;text-align:right" ><input style="width:60px;text-align:right" readonly="readonly" value="$this->subtotal" id="subtotal" name="subtotal"></td>
            <td  style="text-align:center;"></td>
            <td  style="text-align:center;"></td>
         </tr>
</tfooter>
                	
				         

EOF;

        $form.=<<< EOF
 </table>
</div>
EOF;

        return $form;
    }

    public function viewsubtable() {
        global $havewriteperm, $defcurrencycode, $userid, $sbfe;
        include_once "../simantz/class/SelectCtrl.inc.php";
        include_once "../simbiz/class/SimbizSelectCtrl.inc.php";
        $ctrl = new SelectCtrl();
        $bpctrl = new SimbizSelectCtrl();

        $form = "";
        $i = 0;
//second table
        $sql = "SELECT il.*,o.organization_code
                FROM sim_bpartner_quotationline il
                LEFT JOIN sim_simbiz_accounts a ON a.accounts_id=il.accounts_id
                left join sim_organization o on o.organization_id=il.branch_id
                 WHERE il.quotation_id=$this->quotation_id order by il.seqno ASC";

        $this->log->showLog(4, "getsubtalbe :" . $sql . "<br>");
        $query = $this->xoopsDB->query($sql);

        $form .=<<< EOF



<div align="center">


<table id="quotationline" class="" style="width:100%">

   <tr class="searchformheader" >
     <td colspan="8">
       <table><tr><td>
              <div style="float:left;cursor:pointer"><a onclick="addLine()">[Add Line]</a></div>
              <div style="float:center">Item(s)</div>
       </td></tr></table>
     </td>
   </tr>

   <tr class="searchformheader" >
          <td style="width:30px;vertical-align:top;">Seq</td>
          <td style="width:250px">Subject</td>
          <td style="width:50px">Unit Price</td>
          <td style="width:50px">Qty</td>
          <td style="width:70px">UOM</td>
          <td style="width:50px">Amount</td>
    </tr>

EOF;
        $g = 0;
        $totalgeneralamt = 0;
        global $sbfe;

        while ($row = $this->xoopsDB->fetchArray($query)) {
            if ($rowtype == "odd")
                $rowtype = "even";
            else
                $rowtype = "odd";
            $subject = htmlspecialchars($row['subject']);
            $description = htmlspecialchars($row['description']);
            if ($description == '')
                $hidedesc = " style='display:none;width:350px' ";
            else
                $hidedesc = " style='width:350px' ";

            $amt = $row['amt'];
            $localamt = $row['localamt'];
            $totalgeneralamt+=$amt;
            $quotationline_id = $row['quotationline_id'];
            $accounts_id = $row['accounts_id'];
            $terms_id = $row['terms_id'];
            $terms_name = $row['terms_name'];
            $quotation_amt = $row['quotation_amt'];
            $unitprice = $row['unitprice'];

            $qty = $row['qty'];
            $uom = $row['uom'];
            $gstamt = $row['gstamt'];
           // $tax_name = $row['tax_name'];
            $organization_code = $row['organization_code'];
            $granttotalamt = $row['granttotalamt'];
            $localgranttotalamt = $row['localgranttotalamt'];
            $localamt = $row['localamt'];
            $accounts_name = $row['accountcode_full'] . " - " . $row['accounts_name'];

//            $tax = $row['total_tax'] * 0.01;
//name="lineaccount_id[$i]" id="account_id_$i"
//<select name="lineaccount_id[$i]" id="account_id_$i" onfocus=getList(this.id,this.value) style='width:300px'>$acclist</select><img onclick='clearlist()' src='../simantz/images/reload.gif' title='reload'/>
//			$acclist=$bpctrl->getSimpleSelectAccounts($accounts_id,'Y',"and accounts_id=$accounts_id");
            $orgctrl = $ctrl->selectionOrg($userid, $row['branch_id'], 'N');
            $seqno = $row['seqno'];
            $description = str_replace("\n", "<br/>", $description);
            $description = str_replace("  ", " &nbsp;", $description);

            $form .=<<< EOF
         <tr class="$rowtype" id='trline_$i'>
            <td class="$rowtype" style='vertical-align:top;'>$seqno</td>
            <td style="text-align:left;vertical-align:top;">
             $subject<br/>
            $description
            </td>

            <td style='text-align:right;vertical-align:top;'>$unitprice</td>
            <td style='text-align:right;vertical-align:top;'>$qty</td>
            <td style='text-align:center;vertical-align:top;'>$uom</td>
			<td  style='vertical-align:top;text-align:right;'>
						$amt
				</td>

         </tr>

EOF;
            $i++;
            $g++;
        }

        $totalgeneralamt = number_format($totalgeneralamt, "2", ".", "");
        $form .=<<< EOF
<tfooter>
         <tr class="foot" id="trlinetotal">
			<td ></td>
         
            <td >
                                 <input type="hidden" value="$i" name="totalline" id="totalline">
            </td>
            <td   colspan='3' style="width:60px;text-align:right">Sub Total $this->currency_code:</td>
            <td  style="width:60px;text-align:right" >$this->subtotal</td>
         </tr>
        
</tfooter>
                	
				         

EOF;

        $form.=<<< EOF
 </table>
</div>
EOF;

        return $form;
    }

    public function updateQuotation() {
        $this->log->showLog(2,"begin updateQuotation");
     include_once "../simantz/class/Save_Data.inc.php";
     
     $sql="SELECT sum(amt) as amt from sim_bpartner_quotationline where quotation_id=$this->quotation_id";
     $q=$this->xoopsDB->query($sql);
     $row=$this->xoopsDB->fetchArray($q);
     $amt=$row['amt'];
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
        "%s",
        "%s",
        "%s",
        "%d"
);
    $arrvalue=array($this->document_no,
   $this->document_date,
   $this->currency_id,
   $this->exchangerate,
   $amt,
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
   $amt,
   $this->address_text,
   $this->address_id,
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

    public function updateIsComplete($quotation_id, $iscomplete) {

        include include "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();

        $arrUpdateField = array('updated', 'updatedby', 'iscomplete');
        $arrUpdateFieldType = array('%s', '%d', '%d');
        $arrvalue = array($this->updated, $this->updatedby, $iscomplete);

        if ($save->UpdateRecord($this->tablename, "quotation_id", $this->quotation_id, $arrUpdateField, $arrvalue, $arrUpdateFieldType, $this->spquotation_prefix . $this->document_no))
            return true;
        else
            return false;
    }

    public function deleteQuotation($quotation_id) {
     include "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
    $this->log->showLog(3,"Access deleteQuotation($quotation_id)");
    
   if($this->fetchQuotation($quotation_id)){
   
    return $save->DeleteRecord("sim_bpartner_quotation","quotation_id",$quotation_id,$this->spquotation_prefix.$this->document_no,1);
   }
   else
       return false;
    }

    public function saveQuotationLine() {
        global $xoopsDB, $userid, $defaultorganization_id, $xoopsUser;
        include_once "../simantz/class/Save_Data.inc.php";

        $timestamp = date("Y-m-d H:i:s", time());
        $createdby = $userid;

        $this->log->showLog("2", "Access saveLine with totalline:" . $_POST['totalline'] . ",quotationline_id:" . print_r($_POST['linequotationline_id'], true));


        $timestamp = date("Y-m-d H:i:s", time());
        $createdby = $xoopsUser->getVar('uid');
        $uname = $xoopsUser->getVar('uname');
        $uid = $userid;

        $exchangerate = $_REQUEST['exchangerate'];
        if (!$exchangerate > 0)
            $exchangerate = 1;
        $tablename = "sim_bpartner_quotationline";

        $save = new Save_Data();

        $arrInsertField = array(
            "seqno", "subject", "description", "unitprice",
            "qty", "uom",  "amt", "quotation_id", "created", "createdby", "updated", "updatedby",
            );

        $arrInsertFieldType = array(
            "%d", "%s", "%s",  "%f",
            "%f", "%s",  "%f", "%d",  "%s", "%d", "%s", "%d",
            );

        $arrUpdateField = array(
            "seqno", "subject", "description", "unitprice", "qty", "uom",
             "amt", "updated", "updatedby");

        $arrUpdateFieldType = array("%d", "%s", "%s", "%f", "%f", "%s", "%f","%s", "%d"
        );


        $linequotationline_id = $_POST['linequotationline_id'];
        $lineaccount_id = $_POST['lineaccount_id'];
        $linedescription = $_POST['linedescription'];
        $linesubject = $_POST['linesubject'];
        $linebranch_id = $_POST['linebranch_id'];
        $lineamt = $_POST['lineamt'];
        $lineuom = $_POST['lineuom'];
        $lineqty = $_POST['lineqty'];
        $lineunitprice = $_POST['lineunitprice'];
        $linelocalamt = $_POST['linelocalamt'];
        $linetax_id = $_POST['linetax_id'];
        $linegstamt = $_POST['linegstamt'];

        $linegranttotalamt = $_POST['linegranttotalamt'];
        $linelocalgranttotalamt = $_POST['linelocalgranttotalamt'];
        $linetrack1_id = $_POST['linetrack1_id'];
        $linetrack2_id = $_POST['linetrack2_id'];
        $linetrack3_id = $_POST['linetrack3_id'];
        $lineseqno = $_POST['lineseqno'];
        $totalline = $_POST['totalline'];
        $this->log->showLog(4, "submited data=" . print_r($_POST, true));
        // Yes there are INSERTs to perform...
        for ($i = 0; $i < $totalline; $i++) {

            $quotationline_id = $linequotationline_id[$i];
            $accounts_id = $lineaccount_id[$i];
            $quotation_no = $linequotation_no[$i];
            $description = $linedescription[$i];
            $subject = $linesubject[$i];
            $branch_id = $defaultorganization_id; //$linebranch_id[$i];
            $tax_id = $linetax_id[$i];
            $unitprice = $lineunitprice[$i];
            $qty = $lineqty[$i];
            $uom = $lineuom[$i];
            $amt = $lineamt[$i];
            $localamt = $linelocalamt[$i];
            $gstamt = $linegstamt[$i];
            $granttotalamt = $linegranttotalamt[$i];
            $localgranttotalamt = $linelocalgranttotalamt[$i];
            $track1_id = $linetrack1_id[$i];
            $track2_id = $linetrack2_id[$i];
            $track3_id = $linetrack3_id[$i];
            $seqno = $lineseqno[$i];


            if ($quotationline_id > 0) {
                $arrvalue = array(
                    $seqno,
                    $subject,
                    $description,
                    $unitprice,
                    $qty,
                    $uom,
                    
                    $amt,
                 
                    $timestamp,
                    $createdby,
                   
                );
                $this->log->showLog(3, "***updating record($currentRecord), quotationline:subject" .
                        $subject);

                $controlvalue = $subject;

                if ($save->UpdateRecord($tablename, "quotationline_id", $quotationline_id, $arrUpdateField, $arrvalue, $arrUpdateFieldType, $controlvalue)) {
                    if ($save->failfeedback != "") {
                        $save->failfeedback = str_replace($this->failfeedback, "", $save->failfeedback);
                        $this->failfeedback.=$save->failfeedback;
                    }
                } else {
                    $this->log->showLog("Cannot update quotation line for $subject");
                    return false;
                }
            } elseif ($quotationline_id == '') {
                
            } elseif ($quotationline_id == 0) {
                $arrvalue = array(
                    $seqno,
                    $subject,
                    $description,
                    $unitprice,
                    $qty,
                    $uom,
                  
                    $amt,
                    $this->quotation_id,
                 
                    $timestamp,
                    $createdby,
                    $timestamp,
                    $createdby,
                   
                );

                $controlvalue = $subject;
                if ($save->InsertRecord($tablename, $arrInsertField, $arrvalue, $arrInsertFieldType, $controlvalue, "quotationline_id")) {
                    if ($save->failfeedback != "") {
                        $save->failfeedback = str_replace($this->failfeedback, "", $save->failfeedback);
                        $this->failfeedback.=$save->failfeedback;
                    }
                } else {
                    $this->log->showLog(2, "Cannot insert record for $subject");
                    return false;
                }
                // Now we execute this query
            }
        }
        $this->log->showLog(2, "Complete run savequotationline successfully");
        return true;
    }

    public function getQuotationLineSubject($quotationline_id) {

        $sql = "select concat(subject,'(',i.spquotation_prefix,i.document_no,')')  as subject from sim_bpartner_quotationline il
            inner join sim_bpartner_quotation i on il.quotation_id=i.quotation_id
        where il.quotationline_id=$quotationline_id";
        $this->log->showLog(3, "access getQuotationLineSubject($quotationline_id)");
        $this->log->showLog(4, "with sql: $sql");

        $query = $this->xoopsDB->query($sql);
        $row = $this->xoopsDB->fetchArray($query);
        return $row['subject'];
    }

    public function GetTempWindow() {
        global $nitobigridthemes, $havewriteperm, $defcurrencycode;

        $sql = "SELECT * FROM simerp_descriptiontemp order by descriptiontemp_name ASC";
        $this->log->showLog(4, "GetTempWindow :" . $sql . "<br>");
        $query = $this->xoopsDB->query($sql);

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
        $i = 0;
        while ($row = $this->xoopsDB->fetchArray($query)) {
            $i++;
            if ($rowtype == "odd")
                $rowtype = "even";
            else
                $rowtype = "odd";
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

    public function includeTempFormJavescript($window) {
        if ($window == "sales")
            $link = "receipt.php";
        else if ($window == "purchase")
            $link = "paymentvoucher.php";

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


// end of open temp window


  </script>

EOF;
    }

    public function GetSaveTempWindow() {
        global $nitobigridthemes, $havewriteperm, $defcurrencycode;

        $sql = "SELECT * FROM simerp_descriptiontemp order by descriptiontemp_name ASC";
        $this->log->showLog(4, "GetTempWindow :" . $sql . "<br>");
        $query = $this->xoopsDB->query($sql);

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

    public function saveTemp() {
        global $defaultcurrency_id;
        include_once "../simantz/class/Save_Data.inc.php";
        global $defaultpicture, $uploadpath, $selectspliter, $xoopsDB, $xoopsUser, $defaultorganization_id;
        $save = new Save_Data();
        $timestamp = date("Y-m-d H:i:s", time());
        $createdby = $xoopsUser->getVar('uid');
        $uname = $xoopsUser->getVar('uname');

        $arrInsertField = array("descriptiontemp_name", "descriptiontemp_content",
            "created", "createdby", "updated", "updatedby");

        $arrInsertFieldType = array("%s", "%s", "%s", "%d", "%s", "%d");

        $arrvalue = array($this->descriptiontemp_name,
            $this->descriptiontemp_content,
            $timestamp,
            $createdby . $selectspliter . $uname,
            $timestamp,
            $createdby . $selectspliter . $uname);

        return $save->InsertRecord("simerp_descriptiontemp", $arrInsertField, $arrvalue, $arrInsertFieldType, $this->descriptiontemp_name, "descriptiontemp_id", $timestamp);
    }

    public function deleteTemp($descriptiontemp_id) {
        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();
        return $save->DeleteRecord("simerp_descriptiontemp", "descriptiontemp_id ", $descriptiontemp_id, $descriptiontemp_id, 1);
    }

    public function deleteLine($quotationline_id) {
        global $xoopsDB, $xoopsUser, $timestamp, $createdby, $uname, $uid;
        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();

        $tablename = "sim_bpartner_quotationline";
        $record_id = $quotationline_id;
        $controlvalue = '';
        $this->log->showLog(3, "delete: $currentRecord,$record_id");
        $rs = $save->DeleteRecord("sim_bpartner_quotationline", "quotationline_id", $record_id, $controlvalue, 1);
        if (!$rs) {
            $this->log->showLog(1, "Cannot delete line $quotationline_id");
            return false;
        } else {
            $this->log->showLog(2, "Delete paymentline successfully: $quotationline_id");
            return true;
        }
    }

    public function viewInputForm() {

//        $grid = $this->getGrid($this->quotation_id);
        $this->address_text = str_replace("\n", "<br/>", $this->address_text);
        $this->address_text = str_replace("  ", " &nbsp;", $this->address_text);
        $this->description = str_replace("\n", "<br/>", $this->description);
        $this->description = str_replace("  ", " &nbsp;", $this->description);
//        $balanceamt = $this->getOutstandingAmt($this->quotation_id);
  //      $paymenthistory = $this->getPaymentHistory($this->quotation_id);
        if ($this->batch_id > 0)
            $viewjournalctrl = "  <a href='batch.php?action=view&batch_id=$this->batch_id' target='_blank'>View Journal</a><br/>";

            $tableheader = "Quotation";

	
		include "../bpartner/class/BPartner.php";
		$bp = new BPartner();
        $creditstatusarr = $bp->checkCreditLimit($this->bpartner_id, $this->organization_id, $this->issotrx);
        $consumecredit = $creditstatusarr["usage"]; 
        $creditlimit = $creditstatusarr["limitamt"];
        
            $credittext = "$creditlimit/$consumecredit";

        if ($this->iscomplete == 1) {
            $documentstatus = "This transaction is completed!";
            $iscompletectrl = "<input type='button' name='save' onclick='reactivateQuotation()' value='Re-activate'/>";
        } else {
            $documentstatus = "This transaction is voided, it doesn't effect account";
            $iscompletectrl = "";
        }

        $startdate = date("Y-m-", time()) . "01";
        $enddate = date("Y-m-d", time());


        $this->note = str_replace("\n", "<br/>", $this->note);
        $this->address_text = str_replace("\n", "<br/>", $this->address_text);
        $this->description = str_replace("\n", "<br/>", $this->description);
        $viewsubtable = $this->viewsubtable();
        $this->defineHeaderButton();



        $html = <<< HTML

<script>
    function reactivateQuotation(){
		if(confirm("Reactivate this record? The transaction from journal will reverse automatically.")){
          var quotation_id=document.getElementById("quotation_id").value;
           var data="action=reactivate&quotation_id="+quotation_id;
            $.ajax({
                        url: "$this->quotationfilename",type: "POST",data: data,cache: false,
							success: function (xml) {
                             if(xml != ""){
                             jsonObj = eval( '(' + xml + ')');

                                if(jsonObj.status==1){
                                window.location="$this->quotationfilename?action=edit&quotation_id=$this->quotation_id";
                                }
                                else
                                alert("Cannot reactivate quotation! Msg: "+jsonObj.msg);
                                }
                                }
                   });

		}
          }
  function previewQuotation(){
	  
                window.open("$this->quotationfilename?action=pdf&quotation_id="+document.getElementById("quotation_id").value)
        }
		function viewlinehistory(il_id){
			//tablename=sim_country&idname=country_id&title=Country
			window.open("../simantz/recordinfo.php?tablename=sim_bpartner_quotationline&idname=quotationline_id&title=$menuname&id="+il_id);
			}

		function viewhistory(){
			
			window.open("../simantz/recordinfo.php?tablename=sim_bpartner_quotation&idname=quotation_id&title=$menuname&id=$this->quotation_id");

			}

	function duplicateQuotation(){
	      var quotation_id=document.getElementById("quotation_id").value;
         //   popup('popUpDiv');
           var data="action=duplicate&quotation_id="+quotation_id;
            $.ajax({
                        url: "$this->quotationfilename",type: "POST",data: data,cache: false,
                success: function (xml) {
                             if(xml != "")
//                             jsonObj = eval( '(' + xml + ')');
                            document.getElementById('idApprovalWindows').innerHTML = xml;

                            document.getElementById('idApprovalWindows').style.display = "";
           //                             popup('popUpDiv');

                }
          });

		}
		    function closeWindow(){
      document.getElementById('idApprovalWindows').style.display = "none";
      document.getElementById('idApprovalWindows').innerHTML = "";
    }

    </script>
    <br/>
    <div id="idApprovalWindows" style="display:none"></div>
<div id='blanket' style='display:none;'></div>

    <div class="searchformblock" style="float:right;">	
       </div>
		
    <div id='centercontainer'>
    <div align="center" >
    <table style="width:990px;text-align: left; " >
        <tr><td align="left">$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr></table>

                $noperm
<b style='color:red;'>$documentstatus</b>

    <br/>

    <div id='errormsg' class='red' style='display:none'></div>
<div>
<form onsubmit='return false' method='post' name='frmQuotation' id='frmQuotation'  action='$this->quotationfilename'  enctype="multipart/form-data">

   <table style="text-align: left; width: 990px;" border="0" cellpadding="0" cellspacing="1"  class="searchformblock">
    <tbody>
        <tr>
        <td colspan="5" rowspan="1" align="center" id="idHeaderText" class="searchformheader" >$tableheader</td>
        </tr>
        <tr>
          <td class="head">Quotation No</td>
          <td class="even">$this->spquotation_prefix $this->document_no   Branch: $this->organization_code</td>
          <td class="head">Business Partner</td>
          <td class="even">
                <a href="../bpartner/bpartner.php?action=viewsummary&bpartner_id=$this->bpartner_id" target="_blank">$this->bpartner_name</a>
          </td>
         <td rowspan='6'></td>
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
      <td class="head">$refno</td>
      <td class="even">$this->ref_no</td>
     </tr>
     <tr>
         <td class="head">Prepared By</td>
         <td class="even">$this->preparedbyname</td>
        <td class="head">Sales Agent</td>
         <td class="even">$this->saleagent_name</td>
</tr>
<tr>
       <td class="head">Address</td>
       <td class="even">$this->address_text
        </td>
         <td class="head">Currency</td>
          <td class="even">$this->currency_code (Exchange Rate: $this->exchangerate)</td>
<tr><td colspan='5'>
    <div id='detaildiv'>
                $viewsubtable
</div>
</td></tr>

<tr><td colspan='5' style='text-align:right'>        
                <input type='button' value='Preview' onclick='javascript:previewQuotation()'/>
        <input name='quotation_id' id='quotation_id'  value='$this->quotation_id'  title='quotation_id' type='hidden'>
        <input name='iscomplete'  id='iscomplete' value='$this->iscomplete'  title='iscomplete' type='hidden'>
                $iscompletectrl
            <input type="button" value="Duplicate" onclick=duplicateQuotation()>
	  <input type='button' id='btnviewhistory' name='btnviewhistory' onclick='viewhistory()' value='View Record Info'/>
	</td>

<tr> <td class="head">Description</td>
<td class="even" colspan='5' style="width:70%">$this->description</td>
       
</tr>
</tr>
   <td class="head">Note</td>
<td class="even" colspan='3'>$this->note</td>
</tr></table>
</form>

</div>
</div>

HTML;
        return $html;
    }



    public function showSearchForm() {
        if ($this->documenttype == 'D') {
            $acctitle = 'Effected Account';
            $title = 'Debit Note';
            $paidto_from_name = '';
            $hideotherselection = "style='display:none'";
        } elseif ($this->documenttype == 'C') {
            $acctitle = 'Effected Account';
            $title = 'Credit Note';
            $paidto_from_name = '';
            $hideotherselection = "style='display:none'";
        } elseif ($this->issotrx == 1 && $this->documenttype == 'I') {
            $title = 'Sales Quotation';
        } elseif ($this->issotrx == 0 && $this->documenttype == 'I') {
            $title = 'Purchase Quotation';
        }

        include "../simantz/class/FormElement.php";
        include "../simbiz/class/SimBizFormElement.inc.php";
        $fe = new FormElement();
        $sbfe = new SimBizFormElement();
        $sbfe->activateAutoComplete();
        $bpbox = $sbfe->getBPartnerBox(0, '', 'bpartner_id', 'bpartner_id', '350px', "debtor");
        $datefrom = date("Y-m-" . "01", time());
        $dateto = date("Y-m-d", time());
        $this->defineHeaderButton();
        echo <<<EOF
	<script>
	
	$(function(){

            $(".tblresult_checkall").live("click", function(){
                   // var check = false;
                  var check = $(this).attr("checked");
                              $(".tblresult_checkall").attr("checked", check)
                    $(".inv_selector").attr("checked" , check);
            })
            
            $(".inv_selector").live("click", function(){
                    if(!$(this).attr("checked")){
                         $(".tblresult_checkall").attr("checked", false);
                    }
            });


        });

function search(){
			var data=$("#frmQuotation").serialize();
			$.ajax({url:"$this->quotationfilename",type: "POST",data: data,cache: false,
                            success: function (xml){
                                
                                $('#searchresult')
                                 .html("<div align='center'><div style='width:990px'>"+xml+"</div></div>");
                                 
                                 
        			$('#resulttable').dataTable({
                                            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100 , "All"]],
                                             "aoColumnDefs": [
                                                { 'bSortable': false, 'aTargets': [ 0,7,8 ] }
                                            ]
                            });
                
                                            $(".btnPrint").button();
                                            //$(".btnPrint").click(function(){
                                                    //var data = $("#frmResult").serialize();
                                                
                                                    //data += "&action=showHtmlListing";
                
                                             //       window.open("$this->quotationfilename"+data);
                
                                             //       return false;
                                                    
                                            //})
                
				}
                
                
                                
                
			});

	return false;
	}

	</script>

<div align=center>
    <table style="width:990px;text-align: left; " >
        <tr><td align="left">$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr></table>
<form method='post' name='frmQuotation' id='frmQuotation'  onsubmit="return search()" action='$this->quotationfilename'  enctype="multipart/form-data">


   <table style="text-align: left; width: 990px;" border="0" cellpadding="0" cellspacing="1"  class="searchformblock">
    <tbody>

      <tr>
        <td colspan="4" rowspan="1" align="center" id="idHeaderText" class="searchformheader" >Search</td>
      </tr>

      <tr>
        <td class="head">Date From(YYYY-MM-DD)</td>
        <td class="even">
            <input id='searchfromdocument_date' name='searchfromdocument_date'  value='$datefrom' size='12' class='datepick'>
            </td>
        <td class="head">Date To(YYYY-MM-DD)</td>
        <td class="even">
            <input id='searchtodocument_date' name='searchtodocument_date'  size='12' value='$dateto' class='datepick'>
            </td>
		</tr>
		      <tr> 
        <td class="head">Document No</td>
        <td class="even">
                         <input name='searchdocument_no' id='searchdocument_no'  value='' size='10'>
                         </td>
        <td class="head">Ref. No</td>
        <td class="even"><input id='searchref_no' size='20' name='searchref_no' value='$this->ref_no'></td>
      </tr>
      <tr>
			</td>
       <td class="head">Business Partner</td>
         <td class="even">$bpbox</td>
       <td class="head">Status</td>
         <td class="even">
			<div id="radioactive">
				<input type="radio" id="iscomplete_a" value='-' name="searchiscomplete" checked/><label for="iscomplete_a">All</label>
				<input type="radio" id="iscomplete_1" value='1' name="searchiscomplete" /><label for="iscomplete_1">Completed</label>
				<input type="radio" id="iscomplete_0" value='0' name="searchiscomplete" /><label for="iscomplete_0">Draft</label>
			</div>

      </tr>
      
</table>
<input type='button' value='Search' id='nextbutton' name='submit' onclick='return search()'/>
<input type='hidden' name='action' value='searchresult'>
</form>
</div>
<form id="frmResult" action="$this->quotationfilename?action=html" method="post" target="_blank">
    <div id='searchresult' align='center'>
    </div>
</form>

EOF;
    }
    
    
    public function showHtmlTable($quotation_id){
        
        $whstr = 'WHERE i.quotation_id IN('.implode(",", $quotation_id). ')';
              //  if ($searchdocument_no != '')
        //$whstr.=" concat(i.spquotation_prefix ,i.document_no) like '%$searchdocument_no%' AND";
                
         $sql = "SELECT i.document_date, i.quotation_id, concat(i.spquotation_prefix	,i.document_no) as docno,i.ref_no,
	i.currency_id,cur.currency_code,,i.iscomplete,
	concat(b.bpartner_no,'-',b.bpartner_name) as bpartner_name,i.bpartner_id, i.quotation_id
	FROM sim_bpartner_quotation i 
	 inner join  sim_bpartner b on b.bpartner_id=i.bpartner_id
	 inner join sim_currency cur on i.currency_id=cur.currency_id
	$whstr
	order by concat(i.spquotation_prefix,i.document_no),i.document_date";
       //echo
        echo <<<EOF
       <table border='1' style='width:100%'>
            <thead>
                <th>Document Date</th>
                <th>Document No.</th>
                <th>BPartner Name</th>
                <th>Currency Code</th>
                <th>Amount</th>
                <th>Is Completed</th>
            </thead>
            <tbody>

EOF;
       //echo $sql;
               $query = $this->xoopsDB->query($sql);
        while ($row = $this->xoopsDB->fetchArray($query)) {
            $document_date = $row['document_date'];
            $quotation_id = $row['quotation_id'];
            $ref_no = $row['ref_no'];
            if ($ref_no != '')
                $ref_no = " ($ref_no)";
            $docno = $row['docno'] . $ref_no;
            $paidto = $row['paidto'];
            $paidfrom = $row['paidfrom'];
            $currency_code = $row['currency_code'];
            $originalamt = $row['localamt'];
            $bpartner_id = $row['bpartner_id'];
            $bpartner_name = $row['bpartner_name'];
            $accounts_name = $row['accounts_name'];
            $iscomplete = $row['iscomplete'];

            $bpartner_name = "<a href='../bpartner/bpartner.php?action=viewsummary&bpartner_id=$bpartner_id' target='_blank'>$bpartner_name</a>";

            if ($iscomplete == 1) {
                $linkname = "<a href='$this->quotationfilename?action=view&quotation_id=$quotation_id' target='_blank'>$docno</a>";
                $iscomplete = "Y";
            } else {
                $linkname = "<a href='$this->quotationfilename?action=edit&quotation_id=$quotation_id' target='_blank'>$docno</a>";
                $iscomplete = '<b style="color:red">N</b>';
            }

            echo <<< EOF
<tr>    
	<td>$document_date</td>
	<td>$linkname</td>
	<td>$bpartner_name</td>
	<td>$currency_code</td>
	<td>$originalamt</td>
	<td>$iscomplete</td>
	</tr>
EOF;
        }
       
       
       echo "</tbody></table>";
        
        
        
    }
    

    public function showResult() {
        $datefrom = $_REQUEST['searchfromdocument_date'];
        $dateto = $_REQUEST['searchtodocument_date'];
        $searchdocument_no = $_REQUEST['searchdocument_no'];
        $searchref_no = $_REQUEST['searchref_no'];
        $bpartner_id = $_REQUEST['bpartner_id'];
        $searchiscomplete = $_REQUEST['searchiscomplete'];
        //$keyword_ctrl = ""
        if ($datefrom == '')
            $datefrom = '0000-00-00';
        if ($dateto == '')
            $dateto = '9999-12-31';

        $wherestr = "WHERE i.document_date BETWEEN '$datefrom' and '$dateto' AND i.issotrx=$this->issotrx AND";

        if ($searchdocument_no != ''){
            $wherestr.=" concat(i.spquotation_prefix	,i.document_no) like '%$searchdocument_no%' AND";
        }
        if ($searchref_no != ''){
            $wherestr.=" i.ref_no like '%$searchref_no%' AND";
        }
        if ($bpartner_id > 0){
            $wherestr.=" i.bpartner_id = $bpartner_id AND";
        }
        if ($searchiscomplete != '-'){
            $wherestr.=" p.iscomplete = $searchiscomplete AND";
        }
        
        $wherestr = left($wherestr, strlen($wherestr) - 3);
        //$wherestr;


        echo <<< EOF

<table id='resulttable'>
<thead> 
<tr>    
        <th width="20px">
            <input type='checkbox' class='tblresult_checkall'/>
        </th>
	<th>Date</th>
	<th>Document No</th>
	<th>Business Partner</th>
	<th>Currency</th>
	<th>Amount</th>
	<th>Is Complete</th>
	<th width="50px">
          
        </th>
                <th width="50px">
                     <!--button class="btnPrint">Print</button-->
                </th>
        
	</tr>
</thead>
<tbody>
EOF;
   $sql = "SELECT i.document_date, i.quotation_id, concat(i.spquotation_prefix	,i.document_no) as docno,i.ref_no,
	i.currency_id,cur.currency_code,i.iscomplete,i.subtotal,
	concat(b.bpartner_no,'-',b.bpartner_name) as bpartner_name,i.bpartner_id
	FROM sim_bpartner_quotation i 
	 inner join  sim_bpartner b on b.bpartner_id=i.bpartner_id
	 inner join sim_currency cur on i.currency_id=cur.currency_id
	$wherestr
	order by concat(i.spquotation_prefix,i.document_no),i.document_date";
        $query = $this->xoopsDB->query($sql);
        while ($row = $this->xoopsDB->fetchArray($query)) {
            $document_date = $row['document_date'];
            $quotation_id = $row['quotation_id'];
            $subtotal=$row['subtotal'];
            $ref_no = $row['ref_no'];
            if ($ref_no != '')
                $ref_no = " ($ref_no)";
            $docno = $row['docno'] . $ref_no;
            $paidto = $row['paidto'];
            $paidfrom = $row['paidfrom'];
            $currency_code = $row['currency_code'];
            $originalamt = $row['localamt'];
            $bpartner_id = $row['bpartner_id'];
            $bpartner_name = $row['bpartner_name'];
            $accounts_name = $row['accounts_name'];
            $iscomplete = $row['iscomplete'];

            $bpartner_name = "<a href='../bpartner/bpartner.php?action=viewsummary&bpartner_id=$bpartner_id' target='_blank'>$bpartner_name</a>";

            if ($iscomplete == 1) {
                $linkname = "<a href='$this->quotationfilename?action=view&quotation_id=$quotation_id' target='_blank'>$docno</a>";
                $linkname1 = "<a href='$this->quotationfilename?action=view&quotation_id=$quotation_id' target='_blank'><img src='../simantz/images/edit.gif'/></a>";
                $iscomplete = "Y";
            } else {
                $linkname = "<a href='$this->quotationfilename?action=edit&quotation_id=$quotation_id' target='_blank'> $docno</a>";
                $linkname1 = "<a href='$this->quotationfilename?action=view&quotation_id=$quotation_id' target='_blank'><img src='../simantz/images/edit.gif'/></a>";
                $iscomplete = '<b style="color:red">N</b>';
            }

            echo <<< EOF
<tr>    
        <td>
            <input type="checkbox" name="quotation_id[]" value='$quotation_id' class='inv_selector'/>
        </td>
	<td>$document_date</td>
	<td>$linkname</td>
	<td>$bpartner_name</td>
	<td>$currency_code</td>
	<td>$subtotal</td>
	<td>$iscomplete</td>
        <td align="center" valign="middle">
        $linkname1
        </td>
            
        <td align="center" valign="middle">
            <a target="_blank" href="$this->quotationfilename?action=pdf&quotation_id=$quotation_id">
                <img src='../simantz/images/zoom.png'/>
            </a>
        </td>
	</tr>
EOF;
        }
        echo <<< EOF
</tbody>
<tfoot> 
	<tr> 
        <th width="20px">
            <input type='checkbox' class='tblresult_checkall'/>
        </th>
	<th>Date</th>
	<th>Document No</th>
	<th>Business Partner</th>
	<th>Currency</th>
	<th>Amount</th>
	<th>Is Complete</th>
        <th width="50px">
            
        </th>
        <th width="50px">
              <!--button class='btnPrint'>Print</button-->
        </th>
	</tr> 
	</tfoot> 
	
</table>
EOF;

    }

    public function defineHeaderButton() {
        global $action;

        $this->addnewctrl = '<form action="' . $this->quotationfilename . '" ><input type="submit" value="Add New"></form>';

        if ($action == "search") {
            $this->searchctrl = '';
        }
        else
            $this->searchctrl = '<form action="' . $this->quotationfilename . '?action=search" ><input type="hidden" name="action" value="search"><input type="submit" value="Search"></form>';
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
       
       echo <<< EOF
<div class="dimBackground"></div>
<div align="center" >
<div style="height:45px"  class="floatWindow" id="tblSub">
<table>
 <tr>
  <td astyle="vertical-align:middle;" align="center">

    <table class="" style="width:850px">

       <tr class="tdListRightTitle" >
          <td colspan="4">
                <table><tr>
                <td id="idHeaderText" align="center">Duplicate</td>
                <td align="right" width="30px"><img src="../simbiz/images/close.png" onclick="closeWindow();" style="cursor:pointer" title="Close"></td>
                </tr></table>
          </td>
       </tr>
			<td>Record duplicated successfully, new quotation is: <a href="salesquotation.php?action=edit&quotation_id=$qid"> $this->spquotation_prefix $this->document_no</a></td>
       <tr>
      </table>
</div></div>
EOF;

       return array($qid,$this->spquotation_prefix.$this->document_no);
    }
    
    echo <<< EOF
<div class="dimBackground"></div>
<div align="center" >
<div style="height:480px;overflow:auto;"  class="floatWindow" id="tblSub">
<table>
 <tr>
  <td astyle="vertical-align:middle;" align="center">

    <table class="" style="width:800px">

       <tr class="tdListRightTitle" >
          <td colspan="4">
                <table><tr>
                <td id="idHeaderText" align="center">Duplicate</td>
                <td align="right" width="30px"><img src="../simbiz/images/close.png" onclick="closeWindow();" style="cursor:pointer" title="Close"></td>
                </tr></table>
          </td>
       </tr>
			<td>cannot duplicate this quotation due to sql error</td>
       <tr>
      </table>
</div></div>
EOF;
EOF;
    return array(0,"");
    
 //sim_bpartner_quotationline
  }
}

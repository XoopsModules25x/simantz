<?php
include "system.php";
include "menu.php";
include_once 'class/Batch.php';
include_once 'class/Transaction.php';

//include_once 'class/SelectCtrl.php';
include_once "../simantz/class/datepicker/class.datepicker.php";
//include_once "../system/class/Period.php";
$dp=new datepicker($url);
$dp->dateFormat='Y-m-d';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$log = new Log();

$s = new XoopsSecurity();
$ctrl= new SelectCtrl();
$trans= new Transaction();
$o = new Batch();
$orgctrl="";


$action="";

$trans->widthaccounts = " style='width: 160px' ";
$trans->widthbpartner = " style='width: 160px' ";

//marhan add here --> ajax
echo "<iframe src='batch.php' name='nameValidate' id='idValidate' style='display:none' width='100%'></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////


echo <<< EOF
<script type="text/javascript">

	function autofocus(){
	document.forms['frmBatch'].batchdate.focus();
	document.forms['frmBatch'].batchdate.select();

	calculation();
	}

	function showHideDesc(i){

	var descctrl=document.getElementById("ctrllinedesc"+i);
	if(descctrl.style.display=="none")
		descctrl.style.display="";
	else
		descctrl.style.display="none";

	}

	function showHideDescHeader(type){
	if(type == 1)
	idDesc = "linedescdef";
	else
	idDesc = "linedescref";

	var descctrl=document.getElementById(idDesc);
	if(descctrl.style.display=="none")
		descctrl.style.display="";
	else
		descctrl.style.display="none";
	}

	function validatePeriodDate(){
	batchdate = document.forms['frmBatch'].batchdate.value;
	var arr_fld=new Array("action","batchdate");//name for POST
	var arr_val=new Array("validateperioddate",batchdate);//value for POST
	
	getRequest(arr_fld,arr_val);
	}

	function checkFldDefault(thisname){

	if(thisname == "defaultcredit")
	document.forms['frmBatch'].defaultdebit.value="0.00";
	else
	document.forms['frmBatch'].defaultcredit.value="0.00";

	document.forms['frmBatch'].totaldebit.value = (parseFloat(document.forms['frmBatch'].refamtvaluedebit.value) + parseFloat(document.forms['frmBatch'].defaultdebit.value)).toFixed(2);
	document.forms['frmBatch'].totalcredit.value = (parseFloat(document.forms['frmBatch'].refamtvaluecredit.value) + parseFloat(document.forms['frmBatch'].defaultcredit.value)).toFixed(2);


	if(document.forms['frmBatch'].totaldebit.value == document.forms['frmBatch'].totalcredit.value)
	document.forms['frmBatch'].btncomplete.style.display = "";
	else
	document.forms['frmBatch'].btncomplete.style.display = "none";

        rdebit = parseFloat(document.forms['frmBatch'].defaultdebit.value);
        rcredit = parseFloat(document.forms['frmBatch'].defaultcredit.value);

	document.forms['frmBatch'].defaultcredit.value = rcredit.toFixed(2);
        document.forms['frmBatch'].defaultdebit.value = rdebit.toFixed(2);

	}


	function checkRefValue(thisname){
	var credit = document.forms['frmBatch'].refamtvaluecredit.value;
	var debit = document.forms['frmBatch'].refamtvaluedebit.value;
	var defaultcredit = document.forms['frmBatch'].defaultcredit.value;
	var defaultdebit = document.forms['frmBatch'].defaultdebit.value;

	
	if(thisname == "refamtvaluecredit"){
	document.forms['frmBatch'].refamtvaluedebit.value = '0.00';
	}else if(thisname == "refamtvaluedebit"){
	document.forms['frmBatch'].refamtvaluecredit.value = '0.00';
	}

	document.forms['frmBatch'].totaldebit.value = (parseFloat(document.forms['frmBatch'].refamtvaluedebit.value) + parseFloat(document.forms['frmBatch'].defaultdebit.value)).toFixed(2);
	document.forms['frmBatch'].totalcredit.value = (parseFloat(document.forms['frmBatch'].refamtvaluecredit.value) + parseFloat(document.forms['frmBatch'].defaultcredit.value)).toFixed(2);


	if(document.forms['frmBatch'].totaldebit.value == document.forms['frmBatch'].totalcredit.value)
	document.forms['frmBatch'].btncomplete.style.display = "";
	else
	document.forms['frmBatch'].btncomplete.style.display = "none";

        rcredit = parseFloat(document.forms['frmBatch'].refamtvaluecredit.value);
        rdebit = parseFloat(document.forms['frmBatch'].refamtvaluedebit.value);

	document.forms['frmBatch'].refamtvaluecredit.value = rcredit.toFixed(2);
        document.forms['frmBatch'].refamtvaluedebit.value = rdebit.toFixed(2);

	}

	function changelinevalue(thisobject,no,isdebit,masterlineno){

		if(isdebit){
			document.getElementById("creditamt"+no).value="0.00";
		}
		else{
			document.getElementById("debitamt"+no).value="0.00";
		}

                thisobject.value = parseFloat(thisobject.value).toFixed(2);

		calculation();

	}

	function refreshBPartner(val){
	
	var arr_fld=new Array("action","accounts_id");//name for POST
	var arr_val=new Array("refreshbpartner",val);//value for POST
	
	getRequest(arr_fld,arr_val);
	}

	function refreshBPartnerRef(val){
	
	var arr_fld=new Array("action","accounts_id");//name for POST
	var arr_val=new Array("refreshbpartnerref",val);//value for POST
	
	getRequest(arr_fld,arr_val);
	}

	function refreshAccountsLine(val,line){
	
	var arr_fld=new Array("action","accounts_id","line");//name for POST
	var arr_val=new Array("refreshaccountsline",val,line);//value for POST
	
	getRequest(arr_fld,arr_val);

	calculation();
	}

	function showRef(val){
	if(val > 0)
	document.getElementById('refID').style.display = "none";
	else
	document.getElementById('refID').style.display = "";

	document.forms['frmBatch'].refamtvaluedebit.value = "0.00";
	document.forms['frmBatch'].refamtvaluecredit.value = "0.00";
	document.forms['frmBatch'].defaultaccountsref_id.value = "0";
	document.forms['frmBatch'].defaultaccountsref_id.value = "0";
	document.forms['frmBatch'].defaultbpartnerref_id.value = "0";
	document.forms['frmBatch'].btncomplete.style.display = "none";
	//alert(document.forms['frmBatch'].btncomplete.style.display);
	}

	function validateBatchSave2(){
	
		var name=document.forms['frmBatch'].batch_name.value;
		var batchno=document.forms['frmBatch'].batchno.value;
		var period_id=document.forms['frmBatch'].period_id.value;
	
		if(confirm("Save record?")){

		if(name =="" || !IsNumeric(batchno) || batchno=="" ){
		
		alert('Please make sure Batch Name, Batch No, Date is filled with proper value.');
		document.forms['frmBatch'].btnSave.style.display = "";
			return false;

		}else{

			//check all line : linedebitamt , linecreditamt
			var i=0;
			while(i< document.forms['frmBatch'].elements.length){
				var ctl = document.forms['frmBatch'].elements[i].name; 
				var val = document.forms['frmBatch'].elements[i].value;
				
				ctlname = ctl.substring(0,ctl.indexOf("["))
				
				if(ctlname=="linedebitamt" || ctlname=="linecreditamt" || ctl == "defaultdebit" || ctl == "defaultcredit" || ctl == "refamtvaluedebit" || ctl == "refamtvaluecredit"){
					if(!IsNumeric(val)){
					document.forms['frmBatch'].elements[i].style.backgroundColor = "#FF0000";
					alert("Please make sure credit/debit filled with proper value.");
					return false;
					}

				}else
					document.forms['frmBatch'].elements[i].style.backgroundColor = "#FFFFFF";
				i++;
			}//end of check line

			checkClosing();
			return true;

		}
		}else{
			document.forms['frmBatch'].btnSave.style.display = "";
			return false;
		}

	}
        function onChangeAccount(fld_id,line,ctrlid){
          //  ctrlid=0;
	document.getElementById('iddivstatus').innerHTML='Refreshing';
        document.getElementById(ctrlid).onchange();
//            alert("Field:" + fld_id + ",Ctrl:" + ctrlid + ",Line:" + line);
        }

	function validateBatchSave(){
	
		var name=document.forms['frmBatch'].batch_name.value;
		var batchno=document.forms['frmBatch'].batchno.value;
		var period_id=document.forms['frmBatch'].period_id.value;
	
		if(confirm("Save record?")){

		if(name =="" || !IsNumeric(batchno) || batchno=="" ){
		
		alert('Please make sure Batch Name, Batch No, Date is filled with proper value.');
		document.forms['frmBatch'].btnSave.style.display = "";
			return false;

		}else if(document.forms['frmBatch'].defaultaccounts_id.value==0){
		alert('Please make sure Accounts is selected');
		return false;
		}else if(document.forms['frmBatch'].defaultline.value==0 && document.forms['frmBatch'].defaultaccountsref_id.value==0){

		
		alert('Please make sure Line or Reference Accounts is selected.');
		//document.forms['frmBatch'].btnSave.style.display = "";
		return false;
		

		}else{
			//check all line : linedebitamt , linecreditamt
			var i=0;
			while(i< document.forms['frmBatch'].elements.length){
				var ctl = document.forms['frmBatch'].elements[i].name; 
				var val = document.forms['frmBatch'].elements[i].value;
				
				ctlname = ctl.substring(0,ctl.indexOf("["))
				
				if(ctlname=="linedebitamt" || ctlname=="linecreditamt" || ctl == "defaultdebit" || ctl == "defaultcredit" || ctl == "refamtvaluedebit" || ctl == "refamtvaluecredit"){
					if(!IsNumeric(val)){
					document.forms['frmBatch'].elements[i].style.backgroundColor = "#FF0000";
					alert("Please make sure credit/debit filled with proper value.");
					return false;
					}

				}else
					document.forms['frmBatch'].elements[i].style.backgroundColor = "#FFFFFF";
				i++;
			}//end of check line
			
			if(document.forms['frmBatch'].defaultaccounts_id.value>0 && document.forms['frmBatch'].iscomplete==1){
				alert('You cannot complete this batch when you choose to add transaction.');
				document.forms['frmBatch'].btnSave.style.display = "";
				return false;
			}else{
			checkClosing();
			return true;
			}

		}
		}else{
			document.forms['frmBatch'].btnSave.style.display = "";
			return false;
		}

	}

	function checkClosing(){
	var batchdate = document.forms['frmBatch'].batchdate.value;
	
	var arr_fld=new Array("action","batchdate");//name for POST
	var arr_val=new Array("checkclosing",batchdate);//value for POST
	
	getRequest(arr_fld,arr_val);

	}
	
	function addCounter(val){
	
	if(val > 0){

	if(confirm("Add Transaction?")){

		if(validateData()){

			/*if(document.frmBatch.defaultdebit.value == 0 && document.frmBatch.defaultcredit.value){
			alert('Please Make Sure Your Debit or Credit Value is filled in.');
			return false;
			}*/
			document.frmBatch.submit();
		}else{
			document.frmBatch.newtrans_accounts_id.value = 0;
		}
	}else{
		document.frmBatch.newtrans_accounts_id.value = 0;
	}

	}

	}

	function addLine(trans_id){
	//	document.frmBatch.addnewcounterline.value=trans_id;
		if(validateData()){
		document.frmBatch.submit();
		}

	}

	function deleteLine(val){

	if(val == true){
	
	if(confirm("Delete This Line?")){

		if(validateData()){
		document.frmBatch.submit();
		}
	}
	
	}

	}

	function saveBatch(){

	if(validateBatch())
	checkClosing();
	//document.frmBatch.submit();

	}


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

	function validateData(){
		
		var name=document.forms['frmBatch'].batch_name.value;
		var batchno=document.forms['frmBatch'].batchno.value;
		var period_id=document.forms['frmBatch'].period_id.value;
	
		

		if(name =="" || !IsNumeric(batchno) || batchno=="" ){
		
		alert('Please make sure Batch Name, Batch No, Date is filled with proper value.');
		return false;

		}else{
			//check all line : linedebitamt , linecreditamt
			var i=0;
			while(i< document.forms['frmBatch'].elements.length){
				var ctl = document.forms['frmBatch'].elements[i].name; 
				var val = document.forms['frmBatch'].elements[i].value;
				
				ctlname = ctl.substring(0,ctl.indexOf("["))
				
				if(ctlname=="linedebitamt" || ctlname=="linecreditamt" || ctl == "defaultdebit" || ctl == "defaultcredit" || ctl == "refamtvaluedebit" || ctl == "refamtvaluecredit"){
					if(!IsNumeric(val)){
					document.forms['frmBatch'].elements[i].style.backgroundColor = "#FF0000";
					alert("Please make sure credit/debit filled with proper value.");
					return false;
					}

				}else
					document.forms['frmBatch'].elements[i].style.backgroundColor = "#FFFFFF";
				i++;
			}//end of check line
			
			return true;
		}
		
		

	}

	function validateBatch(){
		
		var name=document.forms['frmBatch'].batch_name.value;
		var batchno=document.forms['frmBatch'].batchno.value;
		var period_id=document.forms['frmBatch'].period_id.value;

		if(confirm("Save record?")){

		if(name =="" || !IsNumeric(batchno) || batchno=="" ){
		
		alert('Please make sure Batch Name, Batch No, Date is filled with proper value.');
		document.forms['frmBatch'].btnSave.style.display = "";
			return false;

		}else if(document.forms['frmBatch'].defaultline.value==0 && document.forms['frmBatch'].defaultaccountsref_id.value==0){

		
		alert('Please make sure Line is selected.');
		//document.forms['frmBatch'].btnSave.style.display = "";
		return false;
		

		}else{

			
			if(document.forms['frmBatch'].defaultaccounts_id.value>0 && document.forms['frmBatch'].iscomplete==1){
				alert('You cannot complete this batch when you choose to add transaction.');
				document.forms['frmBatch'].btnSave.style.display = "";
				return false;
			}

			return true;

		}
		}else{
			document.forms['frmBatch'].btnSave.style.display = "";
			return false;
		}

	}
	function autofocus2(){
		
		//document.forms['frmBatch'].batch_name.focus();
		//calculation();

	}

	function autofill(i,type)
	{
		if(type=='D')
		document.forms['frmBatch'].elements["linedebitamt["+i+"]"].value
		else
		document.forms['frmBatch'].elements["linecreditamt["+i+"]"].value

	}	

	function calculation(){

	var debitamt=0;
	var creditamt=0;
	var recordcount=document.forms['frmBatch'].maxlineno.value;
	//var amt=parseFloat(document.forms["frmpayment"].elements["balancefees["+id+"]"].value);

	
	var i=0;
	while(i<=recordcount){
//		alert(i);

//		if(parseFloat(document.forms['frmBatch'].elements["lineaccounts_id["+i+"]"].value>0))
//		lineaccountsval = eval("document.forms['frmBatch'].elements[lineaccounts_id["+i+"]].value;");
	
		try {
		if(parseFloat(document.forms['frmBatch'].elements["lineaccounts_id["+i+"]"].value) > 0){
		debitamt=debitamt+parseFloat(document.forms['frmBatch'].elements["linedebitamt["+i+"]"].value);
		creditamt=creditamt+parseFloat(document.forms['frmBatch'].elements["linecreditamt["+i+"]"].value);
		}
		}catch (error) {
		}
		

		document.forms['frmBatch'].totalcredit.value=creditamt.toFixed(2);
		document.forms['frmBatch'].totaldebit.value=debitamt.toFixed(2);

		if(debitamt.toFixed(2)==creditamt.toFixed(2) && debitamt!=0){
			document.forms['frmBatch'].btncomplete.style.display="";
                document.forms['frmBatch'].totalcredit.style.backgroundColor="#FFFFFF";
                document.forms['frmBatch'].totaldebit.style.backgroundColor="#FFFFFF";
		}else{
			document.forms['frmBatch'].btncomplete.style.display="none";

                document.forms['frmBatch'].totalcredit.style.backgroundColor="#FF0000";
                document.forms['frmBatch'].totaldebit.style.backgroundColor="#FF0000";
                }


			i=i+1;
		}
	
	
	}

  function calculatetransaction(trans_id){
	var recordcount=document.forms['frmBatch'].maxlineno.value;
	var j=0;
	var totaldebit=0;
	var totalcredit=0;

	while(j<recordcount){
		//parseFloat(document.forms['frmBatch'].elements["lineaccounts_id["+i+"]"].value)
//		if(trans_id)
	}
  }

  function highlight(i,colortype){
	var color;
	if(colortype=='ok')
		color="#ff0000";
	if(colortype=='ng')
		color="#000000";
	
	document.getElementById("tr"+i).style.backgroundColor="#ff0000";

	}
</script>

EOF;

$o->batch_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->batch_id=$_POST["batch_id"];
 $trans->defaultaccounts_id=$_POST['defaultaccounts_id'];
}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->batch_id=$_GET["batch_id"];
$trans->defaultaccounts_id=$_GET['defaultaccounts_id'];
}
else
$action="";

$token=$_POST['token'];

$o->batch_name=$_POST["batch_name"];

$reuse=$_POST['reuse'];
$o->organization_id=$_POST['organization_id'];
$o->description=$_POST['description'];
$o->batchno=$_POST['batchno'];

//$period= new Period();
$o->isAdmin=$xoopsUser->isAdmin();
$o->period_id=$_POST['period_id'];


$trans->addline=$_POST['addline'];
$o->iscomplete=$_POST['iscomplete'];
$o->totaldebit=$_POST['totaldebit'];
$o->totalcredit=$_POST['totalcredit'];
$o->batchdate=$_POST['batchdate'];
$chkAddNew=$_POST['chkAddNew'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$o->createdby;
$trans->createdby=$o->createdby;
$trans->updatedby=$trans->createdby;

$trans->linedebitamt=$_POST['linedebitamt'];
$trans->linetrans_id=$_POST['linetrans_id'];
$trans->linecreditamt=$_POST['linecreditamt'];
$trans->linedocument_no=$_POST['linedocument_no'];
$trans->linedocument_no2=$_POST['linedocument_no2'];
$trans->linedesc=$_POST['linedesc'];
$trans->lineaccounts_id=$_POST['lineaccounts_id'];
$trans->linebpartner_id=$_POST['linebpartner_id'];
$trans->linetranstype=$_POST['linetranstype'];
$trans->linetrans_id=$_POST['linetrans_id'];
$trans->linedel=$_POST['linedel'];
$trans->maxlineno=$_POST['maxlineno'];
$o->showcalendar=$dp->show("batchdate");

$trans->defaultbpartner_id=$_POST['defaultbpartner_id'];
$trans->defaultaccountsref_id=$_POST['defaultaccountsref_id'];
$trans->defaultbpartnerref_id=$_POST['defaultbpartnerref_id'];
$trans->defaultline=$_POST['defaultline'];
$trans->refamtvaluedebit=$_POST['refamtvaluedebit'];
$trans->refamtvaluecredit=$_POST['refamtvaluecredit'];


if($trans->defaultaccounts_id=="")
$trans->defaultaccounts_id=0;

if($trans->defaultbpartner_id=="")
$trans->defaultbpartner_id=0;

if($trans->defaultaccountsref_id=="")
$trans->defaultaccountsref_id=0;

if($trans->defaultbpartnerref_id=="")
$trans->defaultbpartnerref_id=0;

if($trans->refamtvaluedebit=="")
$trans->refamtvaluedebit=0;

if($trans->refamtvaluecredit=="")
$trans->refamtvaluecredit=0;



if($trans->defaultline=="")
$trans->defaultline=0;

if ($reuse==1 or $reuse=="on")
	$o->reuse=1;
else
	$o->reuse=0;

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with batch name=$o->batch_name");

	//if ($s->check(true,$token,"CREATE_ACG")){
		
		
		
	if($o->insertBatch()){
		$latest_id=$o->getLatestBatchID();
		$defaultdebit=$_POST["defaultdebit"];
		$defaultcredit=$_POST["defaultcredit"];
		$defaultdocno1=$_POST["defaultdocno1"];
		$refdocno1=$_POST["refdocno1"];
		$defaultchequeno=$_POST["defaultchequeno"];
		$refchequeno=$_POST["refchequeno"];
		$linedescdef=$_POST["linedescdef"];
		$linedescref=$_POST["linedescref"];
		
		$defaultamt=0;

		if($trans->defaultaccountsref_id > 0){

		if($trans->refamtvaluecredit > 0)
		$defaultamt=$defaultdebit;
		else
		$defaultamt=$defaultcredit*-1;

		}else{

			if($defaultdebit>0)
			$defaultamt=$defaultdebit;
			elseif($defaultcredit>0)
			$defaultamt=$defaultcredit*-1;
		}
		$trans->maxlineno=1;
		$reference_id=$trans->insertDefaultLine($latest_id,$trans->defaultaccounts_id,$defaultamt,$trans->defaultbpartner_id,
				$defaultdocno1,$defaultchequeno,$linedescdef,$o->batchno);
		//if($o->addline>0 )

		if($trans->defaultaccountsref_id > 0){

		if($trans->refamtvaluecredit > 0)
		$amountref = $trans->refamtvaluecredit*-1;
		else
		$amountref = $trans->refamtvaluedebit;
		
		$trans->insertBlankLine($latest_id,1,$reference_id,$trans->defaultbpartnerref_id,$trans->defaultaccountsref_id,$amountref,
				$refdocno1,$refchequeno,$linedescref,$o->batchno);
		}else{
		$trans->insertBlankLine($latest_id,$trans->defaultline,$reference_id,$trans->defaultbpartner_id,0,0,
				$refdocno1,$refchequeno,$linedescref,$o->batchno);
		}

		if($o->iscomplete==1){
		$latest_id=$o->getLatestBatchID();
		$o->batch_id = $latest_id;
		$trans->removeUnusedLine($o->batch_id);
		$trans->compileSummary($o->batch_id);
		$trans->insertTransactionSummary($o->batch_id,$defaultorganization_id,$o->iscomplete);

		}
		if($chkAddNew=='on')
		redirect_header("batch.php",$pausetime,"Your data is saved, creating new record");
		else
		redirect_header("batch.php?action=edit&batch_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");

	}else {
			echo "<b style='color:red'>Record cannot save, please reverified data you insert into this record.</b>";
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodctrl=$simbizctrl->getSelectPeriod($o->period_id,'N');
		echo "<table><tr><td>";
		$o->getInputForm("new",-1,$token);

		echo "</td><td>";
		$o->showBatchTable("WHERE batch_id>0 and organization_id=$defaultorganization_id and iscomplete=0","ORDER BY batchno");

		echo "</td></tr></table>";
		}
	/*}else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
			echo "<b style='color:red'>Record cannot save due to token expired. Please resave this record</b>";
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		$o->periodctrl=$ctrl->getSelectPeriod($o->period_id,'N');
		echo "<table><tr>";
		echo "<td>";
		$o->getInputForm("new",-1,$token);
		echo "</td><td>";
		$o->showBatchTable("WHERE batch_id>0 and organization_id=$defaultorganization_id and iscomplete=0","ORDER BY batchno");

		echo "</td></tr></table>";
	}*/
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchBatch($o->batch_id)){

		//create a new token for editing a form
		$nextid=0;
		$previousid=0;
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->periodctrl=$simbizctrl->getSelectPeriod($o->period_id,'N');
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"aonKeyDown='return changearrayfieldEnter(event,this.id,$nextid,$previousid,this.id,this)'",'Y');
		//$o->accountsctrl=$ctrl->getSelectAccountsAjax($accounts_id,'Y',"","lineaccounts_id[$i]");
		$o->transactiontable=$trans->showTransTable($o->batch_id,$o->iscomplete);
                
	echo "<table><tr><td>";
	$o->getInputForm("edit",$o->batch,$token);	
	echo "</td><td>";
	$o->showBatchTable("WHERE batch_id>0 and organization_id=$defaultorganization_id and iscomplete=0","ORDER BY batchno");		
	echo "</td></tr></table><script type='text/javascript'>document.getElementById('iddivstatus').innerHTML='Ready';</script>";
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("batch.php",3,"Some error on viewing your batch data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(true,$token,"CREATE_ACG")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
			$trans->defaultdebit=$_POST["defaultdebit"];
			$trans->defaultcredit=$_POST["defaultcredit"];
			$trans->addnewcounterline=$_POST['addnewcounterline'];
			$trans->newtrans_accounts_id=$_POST['newtrans_accounts_id'];

			if($trans->updateLine($o->batch_id,$o->batchno) && $o->updateBatch()) {//if data save successfully

			
//			if($defaultaccounts_id)

			//1. foreach trans id to check which trans want to add line
			//2. add transaction line, with reference id=trans_id
			//3. add new transaction(if exist),get new trans_id
			//4.add qty of sub transaction for 3.
			
			//if($o->addline>0 )
			//$trans->insertBlankLine($latest_id,$o->addline,$reference_id);

			//if($o->addline>0 && $o->iscomplete==0)
			//$trans->insertBlankLine($o->batch_id,$o->addline,$reference_id);

			//start effect alot of accounts, and parent accounts
			if($o->iscomplete==1){
				$trans->removeUnusedLine($o->batch_id);
				$trans->compileSummary($o->batch_id);
				$trans->insertTransactionSummary($o->batch_id,$defaultorganization_id,$o->iscomplete);
			}
			if($chkAddNew=='on')
				redirect_header("batch.php",$pausetime,"Your data is saved, creating new record");
			else
				redirect_header("batch.php?action=edit&batch_id=$o->batch_id",$pausetime,"Your data is saved.");

		}
		else
			redirect_header("batch.php?action=edit&batch_id=$o->batch_id",$pausetime,"Record saved!");
		}
	else{
		redirect_header("batch.php?action=edit&batch_id=$o->batch_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ACG")){
		
		//if($o->iscomplete == 1){		
		//$trans->reverseSummary($o->batch_id);
		//}

		if($o->deleteBatch($o->batch_id)){
			redirect_header("batch.php",$pausetime,"Data removed successfully.");
		}else
			redirect_header("batch.php?action=edit&batch_id=$o->batch_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("batch.php?action=edit&batch_id=$o->batch_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "reactivate" :
		if($o->fetchBatch($o->batch_id)){

		include_once "class/FinancialYearLine.php";
		$fyl = new FinancialYearLine();
		$allowtrans=$fyl->allowAccountTransactionInDate($defaultorganization_id,$o->batchdate);
		if($allowtrans){



		$o->iscomplete=0;
		$o->updateBatch();
		$trans->reverseSummary($o->batch_id);
		$trans->insertTransactionSummary($o->batch_id,$defaultorganization_id,$o->iscomplete);
		redirect_header("batch.php?action=edit&batch_id=$o->batch_id",$pausetime,"Your data is reactivated.");
		}
		else
		redirect_header("batch.php?action=edit&batch_id=$o->batch_id",3,"<B style='color:red'>You can't activate this record possibly the period is closed at financial year</b>");
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("batch.php",3,"Some error on viewing your batch data, probably database corrupted");
	
  break;

  case "reuseid" :
	//$token=$s->createToken($tokenlife,"CREATE_ACG");
	//$o->reUse();

	if($o->reUse()){

	$latest_id=$o->getLatestBatchID();
	$o->batch_id = $latest_id;

	if($o->fetchBatch($o->batch_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->periodctrl=$simbiz->getSelectPeriod($o->period_id,'N');
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"",'Y');
		//$o->accountsctrl=$ctrl->getSelectAccountsAjax($accounts_id,'Y',"","lineaccounts_id[$i]");
		$o->transactiontable=$trans->showTransTable($o->batch_id);
	echo "<table><tr><td>";
	$o->getInputForm("edit",$o->batch,$token);	
	echo "</td><td>";
	$o->showBatchTable("WHERE batch_id>0 and organization_id=$defaultorganization_id and iscomplete=0","ORDER BY batchno");
	echo "</td></tr></table>";
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("batch.php",3,"Some error on viewing your batch data, probably database corrupted");
	
	}else	//if can't find particular organization from database, return error message
		redirect_header("batch.php",3,"Some error on viewing your batch data, probably database corrupted");

  break;

  case "showsearchform":
	//$o->periodctrl=$ctrl->getSelectPeriod(0,'N');

	$o->accountsctrl=$simbiz->getSelectAccounts(0,'Y',"","accounts_id");
	$o->showcalendarfrom=$dp->show("batchdatefrom");
	$o->showcalendarto=$dp->show("batchdateto");
	$o->showSearchForm();
  break;

  case "showhistory":
	$o->showcalendarfrom=$dp->show("batchdatefrom");
	$o->showcalendarto=$dp->show("batchdateto");
	$o->batchdatefrom=$_POST['batchdatefrom'];
	$o->batchdateto=$_POST['batchdateto'];
	$o->batchno=$_POST['batchno'];
	$o->batch_name=$_POST['batch_name'];
	$o->reuse=$_POST['reusesearch'];
        $o->iscomplete=$_POST['iscompletesearch'];
	$o->showSearchForm();
	$wherestring = " WHERE b.batch_id>0 and b.organization_id=$defaultorganization_id ";
	$wherestring .= $o->genWhereString($o->batchdatefrom,$o->batchdateto,$o->batchno,$o->batch_name,$o->reuse,$o->iscomplete);
	$o->showHistoryTable($wherestring,"ORDER BY b.batchdate DESC,b.batchno DESC");
  break;

  case "checkclosing" :
	//echo $o->batchdate;
	include_once "class/FinancialYearLine.php";
	$fyl = new FinancialYearLine();
	$allowtrans=$fyl->allowAccountTransactionInDate($defaultorganization_id,$o->batchdate);
	$newperiod_id=$fyl->period_id;
//	$retval = $o->checkClosing();

	if($allowtrans == true)
	echo "<script type='text/javascript'>

		self.parent.document.frmBatch.period_id.value=$newperiod_id;
		self.parent.document.frmBatch.submit();
		</script>";
	else
	echo "<script type='text/javascript'>
			alert('Date already closed.');
		</script>";

  break;

  case "refreshbpartner" : //on create new batch, 1st account bpartner
	include_once "class/Accounts.php";
	$acc =  new Accounts();
	$accounts_id=$_POST['accounts_id'];
	$acc->fetchAccounts($accounts_id);
	
	$bpfocus="N";

		if($acc->account_type==2){
		$newbpartner="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$simbiz->getSelectBPartner(0,'N',"","defaultbpartner_id",
			 " and (debtoraccounts_id = $accounts_id and isdebtor=1) ","Y","",$trans->widthbpartner);
		$chequedisplaystyle="none";
		$bpfocus="Y";
		}
		elseif($acc->account_type==3){
		$newbpartner="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$simbiz->getSelectBPartner(0,'N',"","defaultbpartner_id",
			 " and (creditoraccounts_id=$accounts_id and iscreditor=1) ","Y","",$trans->widthbpartner) ;
		$chequedisplaystyle="none";
		$bpfocus="Y";
		}
		elseif($acc->account_type==4){
			$newbpartner="<input type='hidden' value='0' name='defaultbpartner_id'>";
			$chequedisplaystyle="";
		}
		else{			
			$newbpartner="<input type='hidden' value='0' name='defaultbpartner_id'>";
			$chequedisplaystyle="none";
		}

	$checkListAccounts = $o->checkListAccounts($accounts_id);

	if($checkListAccounts == 0)
	$displaybp = "none";
	else
	$displaybp= "";
	
echo <<< EOF
	<script type="text/javascript">

	try {
	self.parent.document.getElementById("ctrlBP").innerHTML = "$newbpartner" ;
	self.parent.document.getElementById("ctrlBP").style.display = "$displaybp";

	if("$chequedisplaystyle"=="none"){
		self.parent.document.getElementById("defaultline").style.display= "";
		self.parent.document.getElementById("defaultchequeno").style.display = "none";
		self.parent.document.getElementById("defaultchequeno").value= "";

	}
	else{
	self.parent.document.getElementById("defaultchequeno").style.display = "";
	self.parent.document.getElementById("defaultline").style.display= "";
	//self.parent.document.getElementById("defaultline").selectedIndex=0;
	}

	if("$bpfocus" == "Y")
	self.parent.document.forms["frmBatch"].defaultbpartner_id.focus();

	}catch (error) {
	}
	



	
	//alert($checkListAccounts);
	</script>
EOF;

  break;

case "refreshbpartnerref" :
	include_once "class/Accounts.php";
	$acc =  new Accounts();
	$accounts_id=$_POST['accounts_id'];
	$acc->fetchAccounts($accounts_id);
	
	$bpfocus="N";
		if($acc->account_type==2){
		$newbpartner="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$simbiz->getSelectBPartner(0,'N',"","defaultbpartnerref_id",
			 " and (debtoraccounts_id = $accounts_id and isdebtor=1) ","Y","",$trans->widthbpartner);
		$chequedisplaystyle="none";
		$bpfocus="Y";
		}
		elseif($acc->account_type==3){
		$newbpartner="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$simbiz->getSelectBPartner(0,'N',"","defaultbpartnerref_id",
			 " and (creditoraccounts_id=$accounts_id and iscreditor=1) ","Y","",$trans->widthbpartner) ;
		$chequedisplaystyle="none";
		$bpfocus="Y";
		}
		elseif($acc->account_type==4){
			$newbpartner="<input type='hidden' value='0' name='defaultbpartnerref_id'>";
			$chequedisplaystyle="";
		}
		else{
			$newbpartner="<input type='hidden' value='0' name='defaultbpartnerref_id'>";
		$chequedisplaystyle="none";
		}

	$checkListAccounts = $o->checkListAccounts($accounts_id);
	
	if($checkListAccounts == 0)
	$styledisplay = "none";
	else
	$styledisplay = "";

echo <<< EOF
	<script type="text/javascript">
	self.parent.document.getElementById("ctrlBPRef").innerHTML = "$newbpartner" ;
	self.parent.document.getElementById("ctrlBPRef").style.display = "$styledisplay";


	if("$chequedisplaystyle"=="none"){
	self.parent.document.getElementById("refchequeno").style.display = "none";
	self.parent.document.getElementById("refchequeno").value = "";
	}
	else{
	self.parent.document.getElementById("refchequeno").style.display = "";
	}

	if("$bpfocus" == "Y")
	self.parent.document.forms["frmBatch"].defaultbpartnerref_id.focus();

	</script>
EOF;

  break;

  case "refreshaccountsline" :
	
	$accounts_id=$_POST['accounts_id'];
	$line=$_POST['line'];

	//$newbpartner=$ctrl->getSelectBPartner(0,'N',"","linebpartner_id[$line]", " and (debtoraccounts_id = $accounts_id or creditoraccounts_id=$accounts_id )","Y");
//$newbpartner=$ctrl->getSelectBPartner_Currency(0,'N',"","linebpartner_id[$line]", " and (bp.debtoraccounts_id = $accounts_id or bp.creditoraccounts_id=$accounts_id )","Y","Y");

	//$newbpartner = $ctrl->getSelectBPartner(0,'Y',"","defaultbpartner_id", " and accounts_id = $accounts_id " );
	include_once "class/Accounts.php";
	$acc= new Accounts();
	$acc->fetchAccounts($accounts_id);
	//	$transctrdisplay='none';
	//	$styledisplay = "";
	$bpfocus="N";

		 if($acc->account_type==2){
		 $newbpartner="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$simbizctrl->getSelectBPartner(0,'N',"","linebpartner_id[$line]",
			 " and (debtoraccounts_id = $accounts_id and isdebtor=1) ","Y","linebpartnerid$line",$trans->widthbpartner);
		 $chequedisplaystyle="none";
		$bpfocus="Y";
		 }
		 elseif($acc->account_type==3){
			 $newbpartner="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$simbizctrl->getSelectBPartner(0,'N',"","linebpartner_id[$line]",
			 " and (creditoraccounts_id=$accounts_id and iscreditor=1) ","Y","linebpartnerid$line",$trans->widthbpartner);
			$chequedisplaystyle="none";
		$bpfocus="Y";
		 }
		elseif($acc->account_type==4){
			$newbpartner="<input type='1hidden' value='0' name='linebpartner_id[$line]'>";
			$chequedisplaystyle="";
			$transctrdisplay='none';
			$styledisplay = "none";
		}
		 else{		
			$newbpartner="<input type='1hidden' value='0' name='linebpartner_id[$line]'>";
			$chequedisplaystyle="none";
			$transctrdisplay='none';
			$styledisplay = "none";
		 }

	$checkListAccounts = $o->checkListAccounts($accounts_id);
	
echo <<< EOF
	<script type="text/javascript">
//	alert($i);
	self.parent.document.getElementById("ctrlBP$line").innerHTML = "$newbpartner" ;
	self.parent.document.getElementById("ctrlBP$line").style.display = "$styledisplay";

	if("$chequedisplaystyle"=="none"){
	self.parent.document.getElementById("document_no2_"+$line).style.display = "none";
	self.parent.document.getElementById("document_no2_"+$line).value = "";
	}
	else
	if("$chequedisplaystyle"==""){
	self.parent.document.getElementById("document_no2_"+$line).style.display = "";
	}

	if("$bpfocus" == "Y")
	self.parent.document.getElementById("linebpartnerid$line").focus();

	/*

	if("$chequedisplaystyle"=="none"){
		self.parent.document.getElementById("defaultline").style.display= "";
		if(self.parent.document.getElementById("refchequeno").style.display== "none"){
			self.parent.document.getElementById("refchequeno").value= "";
			self.parent.document.getElementById("defaultchequeno").value= "";

			}

	}
	else{
	self.parent.document.getElementById("defaultline").style.display= "";
	//self.parent.document.getElementById("defaultline").selectedIndex=0;
	}*/

	</script>
EOF;

  break;

  case "validateperioddate" :
	$batchdate=$_POST['batchdate'];

	$checkdate = $o->checkPeriodID($batchdate);

echo <<< EOF
	<script type="text/javascript">
		
		if($checkdate == 0 || $checkdate == ""){
		alert("Period ID for $batchdate not found. Please Add New Period for this date. ");
		}else{
		self.parent.document.forms['frmBatch'].period_id.value = $checkdate;
		self.parent.validateBatchSave();
		}
	</script>
EOF;

  break;
case "getlistdbaccount":
       include_once "../system/class/AJAXSelection.php.inc";
      $aj=new AJAXSelection();
	$strchar = $_POST["strchar"];
	$idinput = $_POST["idinput"];
	$idlayer = $_POST["idlayer"];
	$ctrlid = $_POST["ctrlid"];
	$ocf = $_POST["ocf"];
	$line = $_POST["line"];
  //  $wherestr= $_POST['wherestr'];
	$selectionlist = $aj->getSelectDBAjax($strchar,$idinput,$idlayer,$ctrlid,$ocf,$o->tableaccounts,
            "accounts_id","concat(accountcode_full,'-',accounts_name)","AND placeholder=0","$line");

echo <<< EOF

	<script type='text/javascript'>
      //  alert("HAHA");
	self.parent.document.getElementById("$idlayer").style.display = "";
	self.parent.document.getElementById("$idlayer").innerHTML = "$selectionlist";
//        self.parent.document.getElementById("$ctrlid").onclick();

	</script>
EOF;
die;
    break;
case "view":
    if($o->fetchBatch($o->batch_id)){
		//create a new token for editing a form
		$nextid=0;
		$previousid=0;
		$token=$s->createToken($tokenlife,"CREATE_ACG");
		$o->periodctrl=$simbizctrl->getSelectPeriod($o->period_id,'N');
		$o->orgctrl=$ctrl->selectionOrg($o->createdby,$o->organization_id,'N',"aonKeyDown='return changearrayfieldEnter(event,this.id,$nextid,$previousid,this.id,this)'",'Y');
		//$o->accountsctrl=$ctrl->getSelectAccountsAjax($accounts_id,'Y',"","lineaccounts_id[$i]");
		$o->transactiontable=$trans->showTransTable($o->batch_id,$o->iscomplete);
	echo "<table><tr><td>";
	$o->viewBatch($batch_id);
	echo "</td><td>";
	$o->showBatchTable("WHERE batch_id>0 and organization_id=$defaultorganization_id and iscomplete=0","ORDER BY batchno");
	echo "</td></tr></table>";
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("batch.php",3,"Some error on viewing your batch data, probably database corrupted");
  
    //
    break;

  default :

	$nextid=0;
	$previousid=0;	
	$token=$s->createToken($tokenlife,"CREATE_ACG");
	$o->orgctrl=$ctrl->selectionOrg($o->createdby,$defaultorganization_id,'N', "aonKeyDown='return changearrayfieldEnter(event,this.id,$nextid,$previousid,this.id,this)'",'Y');
	$o->periodctrl=$simbizctrl->getSelectPeriod(0,'N');
	$o->defaultbpartnerctrl=$simbizctrl->getSelectBPartner($trans->defaultbpartner_id,'Y',"","defaultbpartner_id"," and accounts_id = $trans->defaultaccounts_id ","","",$trans->widthbpartner);
	$o->conversionrate=1;
	//$o->currencyctrl=$ctrl->getSelectCurrency($defaultcurrency_id,'N');
	$o->defaultbpartnerctrlref=$simbizctrl->getSelectBPartner($trans->defaultbpartnerref_id,'Y',"","defaultbpartnerref_id"," and accounts_id = $trans->defaultaccountsref_id ","","",$trans->widthbpartner);


	$o->defaultaccountsctrl=$simbizctrl->getSelectAccountsAjax($trans->defaultaccounts_id,'Y',
		"onchange='refreshBPartner(this.value)'",
		"defaultaccounts_id",'','N','N','Y','defaultaccounts_id',$trans->widthaccounts,"Y");

	$o->defaultaccountsctrlref=$simbizctrl->getSelectAccountsAjax($trans->defaultaccountsref_id,'Y',
		"onchange='refreshBPartnerRef(this.value)' ",
		"defaultaccountsref_id",'','N','N','Y','defaultaccountsref_id',$trans->widthaccounts,"Y");
	echo "<table><tr><td>";
	$o->getInputForm("new",0,$token);
	echo "</td><td>";
	$o->showBatchTable("WHERE batch_id>0 and organization_id=$defaultorganization_id and iscomplete=0","ORDER BY batchno");
	echo "</td></tr></table>";

	echo "
		<script type='text/javascript'>refreshBPartner($trans->defaultaccounts_id);
		document.getElementById('iddivstatus').innerHTML='Ready';</script>";
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

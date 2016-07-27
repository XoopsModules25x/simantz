<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Payroll.php';
include_once 'class/Employee.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Payroll($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

$o->cur_symbol = $cur_symbol;

//marhan add here --> ajax
echo "<iframe src='payroll.php' name='nameValidate' id='idValidate' style='display:none' ></iframe>";
echo "<div id='simit'><form name='frmValidate' target='nameValidate' method='POST'></form></div>";
////////////////////

echo <<< EOF

<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;"> Payroll</span></big></big></big></div><br>

<script type="text/javascript">

	function duplicateUrl(payroll_id){
	document.forms['frmDumm'].action.value = "gotourl";
	document.forms['frmDumm'].payroll_id.value = payroll_id;
	document.forms['frmDumm'].submit();
	
	}
	
	function calculateBase(total,ot,type){
		var total_ot = 0;
		
		if(ot == 'Y')
		total_ot = self.parent.document.forms['frmPayroll'].payroll_amt_totalot.value;
		
//		alert(total);
	
		if(type=="epf"){
		self.parent.document.forms['frmPayroll'].payroll_epfbase.value = parseFloat(total) + parseFloat(total_ot);
		parseelement(self.parent.document.forms['frmPayroll'].payroll_epfbase);
		}else{
		self.parent.document.forms['frmPayroll'].payroll_socsobase.value = parseFloat(total) + parseFloat(total_ot);
		parseelement(self.parent.document.forms['frmPayroll'].payroll_socsobase);
		}
		
		
		
	}

	function autofocus(){
	document.forms['frmPayroll'].payroll_no.focus();
	}

	function updateBase(document){

		if(document.forms['frmPayroll'].issocsoot.checked==true)
		ot_socso = "Y";
		else
		ot_socso = "N";

		if(document.forms['frmPayroll'].isepfot.checked==true)
		ot_epf = "Y";
		else
		ot_epf = "N";

		payroll_id = document.forms['frmPayroll'].payroll_idx.value;
		employee_id = document.forms['frmPayroll'].employee_id.value;
		payroll_amt_comm = document.forms['frmPayroll'].payroll_amt_comm.value;

		totalOT = parseFloat(document.forms['frmPayroll'].payroll_amt_ot1.value) + parseFloat(document.forms['frmPayroll'].payroll_amt_ot2.value) + parseFloat(document.forms['frmPayroll'].payroll_amt_ot3.value) + parseFloat(document.forms['frmPayroll'].payroll_amt_ot4.value);
		
		document.forms['frmPayroll'].payroll_amt_totalot.value = totalOT;
		basic_salary = document.forms['frmPayroll'].payroll_basicsalary.value;

		parseelement(self.parent.document.forms['frmPayroll'].payroll_amt_totalot);

		var arr_fld=new Array("action","ot_socso","ot_epf","payroll_id","employee_id","payroll_amt_comm","basic_salary");//name for POST
		var arr_val=new Array("updatebase",ot_socso,ot_epf,payroll_id,employee_id,payroll_amt_comm,basic_salary);//value for POST
		
		getRequest(arr_fld,arr_val);
		
		/*
		alert('EPF & SOCSO (Base) Updated');
		updateSocsoEpf(document);
		*/

	}
	
	function updateBaseAllowance(document){

		if(document.forms['frmPayroll'].issocsoot.checked==true)
		ot_socso = "Y";
		else
		ot_socso = "N";

		if(document.forms['frmPayroll'].isepfot.checked==true)
		ot_epf = "Y";
		else
		ot_epf = "N";

		payroll_id = document.forms['frmPayroll'].payroll_idx.value;
		employee_id = document.forms['frmPayroll'].employee_id.value;
		payroll_amt_comm = document.forms['frmPayroll'].payroll_amt_comm.value;


		
		var arr_fld=new Array("action","ot_socso","ot_epf","payroll_id","employee_id","payroll_amt_comm");//name for POST
		var arr_val=new Array("updatebase",ot_socso,ot_epf,payroll_id,employee_id,payroll_amt_comm);//value for POST
		
		getRequest(arr_fld,arr_val);
		

		updateSocsoEpfAllowance(document);

	}
	
	function updateSocsoEpfAllowance(document){


	var epf_base = document.forms['frmPayroll'].payroll_epfbase.value;
	var socso_base = document.forms['frmPayroll'].payroll_socsobase.value;
	
	var payroll_id = document.forms['frmPayroll'].payroll_idx.value;

	var arr_fld=new Array("action","epf_base","socso_base","payroll_id");//name for POST
	var arr_val=new Array("updatesocsoepf",epf_base,socso_base,payroll_id);//value for POST
	
	getRequest(arr_fld,arr_val);
	
	alert('EPF & SOCSO (Base) Updated');
	}

	function completePayroll(complete){
		if(complete==true){
		document.forms['frmPayroll'].btnSave.value = "Complete";
		document.forms['frmPayroll'].btnSave2.value = "Complete";
		}else{
		document.forms['frmPayroll'].btnSave.value = "Save";
		document.forms['frmPayroll'].btnSave2.value = "Save";
		}
	}

	function calculateTotal(basic,type,thisname){

		basic = parseFloat(basic);
		var totalAllowance = 0;
		var totalOT = 0;
		var totalLeave = 0;
		var totalCommission = 0;
		var totalSocsoEPF = 0;

		//socso & epf
		socsoemployee = parseFloat(self.parent.document.forms['frmPayroll'].payroll_socsoemployee.value);
		socsoemployer = parseFloat(self.parent.document.forms['frmPayroll'].payroll_socsoemployer.value);
		epfemployee = parseFloat(self.parent.document.forms['frmPayroll'].payroll_epfemployee.value);
		epfemployer = parseFloat(self.parent.document.forms['frmPayroll'].payroll_epfemployer.value);
		
		totalSocsoEPF = (socsoemployer + epfemployer) - (socsoemployee + epfemployee);

		//ot
		value_ot1 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_value_ot1.value);
		value_ot2 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_value_ot2.value);
		value_ot3 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_value_ot3.value);
		value_ot4 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_value_ot4.value);

		qty_ot1 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_qty_ot1.value);
		qty_ot2 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_qty_ot2.value);
		qty_ot3 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_qty_ot3.value);
		qty_ot4 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_qty_ot4.value);
		
		if(false){
		var daily = basic/20;		
		self.parent.document.forms['frmPayroll'].payroll_amt_ot1.value = currencyFormat(value_ot1*daily*qty_ot1);
		self.parent.document.forms['frmPayroll'].payroll_amt_ot2.value = currencyFormat(value_ot2*daily*qty_ot2);
		self.parent.document.forms['frmPayroll'].payroll_amt_ot3.value = currencyFormat(value_ot3*daily*qty_ot3);
		self.parent.document.forms['frmPayroll'].payroll_amt_ot4.value = currencyFormat(value_ot4*daily*qty_ot4);
		}

		
		totalOT = parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_ot1.value) + parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_ot2.value) + parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_ot3.value) + parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_ot4.value);
		
		self.parent.document.forms['frmPayroll'].payroll_amt_totalot.value = totalOT;

		parseelement(self.parent.document.forms['frmPayroll'].payroll_amt_totalot);
		/*
		//leave
		value_ul = parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_ul.value);
		value_sl = parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_sl.value);
		value_al = parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_al.value);
		value_el = parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_el.value);
		
		totalLeave = value_ul + value_sl + value_al + value_el;
		*/

		var i=0;
		while(i< self.parent.document.forms['frmPayroll'].elements.length){
		var ctlname = self.parent.document.forms['frmPayroll'].elements[i].name; 
		var data = self.parent.document.forms['frmPayroll'].elements[i].value;

		if(ctlname.substring(0,16)=="leaveline_amount"){
		totalLeave += parseFloat(data);
		}

		i++
		}


		//commission
		comm = parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_comm.value);

		totalCommission = comm;

		/*

		//allowance
		allowance1 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_allowance1.value);
		allowance2 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_allowance2.value);
		allowance3 = parseFloat(self.parent.document.forms['frmPayroll'].payroll_amt_allowance3.value);

		totalAllowance = allowance1+allowance2+allowance3+basic;
		*/

		totalAllowance = basic;

		var totalAmount = totalOT + totalAllowance + totalCommission - totalLeave + totalSocsoEPF;

		self.parent.document.forms['frmPayroll'].payroll_totalamount.value = totalAmount;
		parseelement(self.parent.document.forms['frmPayroll'].payroll_totalamount);
		
		if(type==2){
		var objectinput = eval("self.parent.document.forms['frmPayroll']"+"."+thisname);
		parseelement(objectinput);
		}


	}

	function updateName(name1,name2,name3){
		self.parent.document.getElementById('trAllowance1').style.display = "";
		self.parent.document.getElementById('trAllowance2').style.display = "";
		self.parent.document.getElementById('trAllowance3').style.display = "";

		if(name1=="")
		self.parent.document.getElementById('trAllowance1').style.display = "none";
		if(name2=="")
		self.parent.document.getElementById('trAllowance2').style.display = "none";
		if(name3=="")
		self.parent.document.getElementById('trAllowance3').style.display = "none";

		self.parent.document.getElementById('allowanceId1').innerHTML = name1;
		self.parent.document.getElementById('allowanceId2').innerHTML = name2;
		self.parent.document.getElementById('allowanceId3').innerHTML = name3;
	}

	function updateAllowanceRM(basic){

		//self.parent.document.forms['frmPayroll'].payroll_amt_allowance1.value = val1;
		//self.parent.document.forms['frmPayroll'].payroll_amt_allowance2.value = val2;
		//self.parent.document.forms['frmPayroll'].payroll_amt_allowance3.value = val3;
		//self.parent.document.getElementById('basicSalary').innerHTML = "RM " + basic;

		
		self.parent.document.forms['frmPayroll'].payroll_basicsalary.value = basic;
		
//		getAmount("payroll_amt_comm");
	}

	function updateSocsoEpf(document){


	var epf_base = document.forms['frmPayroll'].payroll_epfbase.value;
	var socso_base = document.forms['frmPayroll'].payroll_socsobase.value;
	
	var payroll_id = document.forms['frmPayroll'].payroll_idx.value;

	var arr_fld=new Array("action","epf_base","socso_base","payroll_id");//name for POST
	var arr_val=new Array("updatesocsoepf",epf_base,socso_base,payroll_id);//value for POST
	
	getRequest(arr_fld,arr_val);

	}

	function getAmount(thisname) {//example of ajax
		
		/*
		if(thisname == "payroll_amt_comm" || thisname.substring(0,14) == "payroll_amt_ot"){
		updateBase(document);
		alert('EPF & SOCSO (Contribute) Updated.');
		}*/
		
		employee_id = document.forms['frmPayroll'].employee_id.value;
		payroll_id = document.forms['frmPayroll'].payroll_idx.value;
		basic_salary = document.forms['frmPayroll'].payroll_basicsalary.value;

		//alert(payroll_id);
		var arr_fld=new Array("action","employee_id","payroll_id","thisname","basic_salary");//name for POST
		var arr_val=new Array("getamount",employee_id,payroll_id,thisname,basic_salary);//value for POST
		
		getRequest(arr_fld,arr_val);

		//alert(thisname);
		

		
	}

	function getAmountFrm(thisname) {//example of ajax

		employee_id = document.forms['frmPayroll'].employee_id.value;
		payroll_id = document.forms['frmPayroll'].payroll_idx.value;
		basic_salary = document.forms['frmPayroll'].payroll_basicsalary.value;
	
		var arr_fld=new Array("action","employee_id","payroll_id","thisname","basic_salary");//name for POST
		var arr_val=new Array("getamountfrm",employee_id,payroll_id,thisname,basic_salary);//value for POST
		
		getRequest(arr_fld,arr_val);
			

	}
	

	function getAmount2(thisobject) {//example of ajax
		basic_salary = document.forms['frmPayroll'].payroll_basicsalary.value;
		var arr_fld=new Array("action","employee_id","thisobject","basic_salary");//name for POST
		var arr_val=new Array("getamount2",document.forms['frmPayroll'].employee_id.value,thisobject,basic_salary);//value for POST
		
		getRequest(arr_fld,arr_val);
		
	}

	function getAllowance(employee_id) {//example of ajax
		
		var monthof = document.forms['frmPayroll'].payroll_monthof.value;
		var yearof = document.forms['frmPayroll'].payroll_yearof.value;


		var arr_fld=new Array("action","employee_id","payroll_monthof","payroll_yearof");//name for POST
		var arr_val=new Array("getallowance",employee_id,monthof,yearof);//value for POST
		
		getRequest(arr_fld,arr_val);
		
//		if(thisname == "payroll_amt_comm" || thisname.substring(0,14) == "payroll_amt_ot"){
//		getAmount("payroll_amt_comm");
	//	}
	}

	function searchPayroll(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}

	function showSearch(){//show search form
		document.forms['frmPayroll'].action.value = "search";
		document.forms['frmPayroll'].submit();
	}

	function validatePayroll2(){
		var code=document.forms['frmPayroll'].payroll_no.value;
		var emp=document.forms['frmPayroll'].employee_id.value;
		if(confirm("Save Record?")){
		if( code=="" || emp==0){
			alert('Please make sure No and Employee is filled in.');
			return false;
		}
		else
			return true;
		}
		else
			return false;
	}


	function checkEmployee(cnt){
	if(cnt == "1"){
	alert('Data duplicate. Please select correct month & year.');
	return false;
	}else{
	return true;
	}
	
	}

	function validateEmployee(){
	
	employee_id = document.forms['frmPayroll'].employee_id.value;
	monthof = document.forms['frmPayroll'].payroll_monthof.value;
	yearof = document.forms['frmPayroll'].payroll_yearof.value;

	var arr_fld=new Array("action","employee_id","monthof","yearof");//name for POST
	var arr_val=new Array("checkemployee",employee_id,monthof,yearof);//value for POST
	
	getRequest(arr_fld,arr_val);
	
	}

	function validatePayroll(){
		action = document.forms['frmPayroll'].action.value;
		
		if(confirm("Save Record?")){
			if(validateData()){
				if(action!="update" && action!="edit"){
				validateEmployee();
				return false;
				}else{
				}
			}else{
			return false;
			}
		}else{
			return false;
		}
		
	}

	function validateData(){
		var code=document.forms['frmPayroll'].payroll_no.value;
		var emp=document.forms['frmPayroll'].employee_id.value;
		var yearof=document.forms['frmPayroll'].payroll_yearof.value;
	
	if(code==""||emp==0){
	alert('Please make sure Sales no and Employee is filled in');
	return false;
	}
	
	if(!IsNumeric(yearof)){
	alert("Year is not numeric. Please Key In Again");
	return false;
	}
	
	
	

	var i=0;
	while(i< document.forms['frmPayroll'].elements.length){
		var ctlname = document.forms['frmPayroll'].elements[i].name; 
		var data = document.forms['frmPayroll'].elements[i].value;
	
		//if(ctlname.indexOf("[") > 0)
		//ctlname = ctlname.substring(0,ctlname.indexOf("["))
		//alert(ctlname);
		if(ctlname.substring(0,11)=="payroll_val" ||ctlname.substring(0,11)=="payroll_amt" || ctlname.substring(0,11)=="payroll_qty" || ctlname=="payroll_totalamount" || ctlname.substring(0,11)=="payroll_soc" || ctlname.substring(0,11)=="payroll_epf" || ctlname.substring(0,9)=="leaveline"){
		
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmPayroll'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmPayroll'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmPayroll'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
		}
		
		i++;
		
	}
	
	return true;
	}

	
</script>

EOF;

$o->payroll_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->payroll_id=$_POST["payroll_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->payroll_id=$_GET["payroll_id"];

}
else
$action="";

$token=$_POST['token'];

$o->remarks=$_POST["remarks"];
$o->payroll_remarks2=$_POST["payroll_remarks2"];
$o->payroll_no=$_POST["payroll_no"];

$o->employee_id=$_POST['employee_id'];
$o->payroll_date=$_POST['payroll_date'];
$o->payroll_monthof=$_POST['payroll_monthof'];
$o->payroll_yearof=$_POST['payroll_yearof'];
$o->payroll_value_ot1=$_POST['payroll_value_ot1'];
$o->payroll_value_ot2=$_POST['payroll_value_ot2'];
$o->payroll_value_ot3=$_POST['payroll_value_ot3'];
$o->payroll_value_ot4=$_POST['payroll_value_ot4'];
$o->payroll_qty_ot1=$_POST['payroll_qty_ot1'];
$o->payroll_qty_ot2=$_POST['payroll_qty_ot2'];
$o->payroll_qty_ot3=$_POST['payroll_qty_ot3'];
$o->payroll_qty_ot4=$_POST['payroll_qty_ot4'];
$o->payroll_amt_ot1=$_POST['payroll_amt_ot1'];
$o->payroll_amt_ot2=$_POST['payroll_amt_ot2'];
$o->payroll_amt_ot3=$_POST['payroll_amt_ot3'];
$o->payroll_amt_ot4=$_POST['payroll_amt_ot4'];
$o->payroll_qty_ul=$_POST['payroll_qty_ul'];
$o->payroll_qty_sl=$_POST['payroll_qty_sl'];
$o->payroll_qty_al=$_POST['payroll_qty_al'];
$o->payroll_qty_el=$_POST['payroll_qty_el'];
$o->payroll_amt_ul=$_POST['payroll_amt_ul'];
$o->payroll_amt_sl=$_POST['payroll_amt_sl'];
$o->payroll_amt_al=$_POST['payroll_amt_al'];
$o->payroll_amt_el=$_POST['payroll_amt_el'];
$o->payroll_amt_comm=$_POST['payroll_amt_comm'];
$o->payroll_amt_allowance1=$_POST['payroll_amt_allowance1'];
$o->payroll_amt_allowance2=$_POST['payroll_amt_allowance2'];
$o->payroll_amt_allowance3=$_POST['payroll_amt_allowance3'];
$o->payroll_socsoemployee=$_POST['payroll_socsoemployee'];
$o->payroll_socsoemployer=$_POST['payroll_socsoemployer'];
$o->payroll_epfemployee=$_POST['payroll_epfemployee'];
$o->payroll_epfemployer=$_POST['payroll_epfemployer'];

$o->payroll_totalamount=$_POST['payroll_totalamount'];
$o->payroll_epfbase=$_POST['payroll_epfbase'];
$o->payroll_socsobase=$_POST['payroll_socsobase'];
$o->payroll_basicsalary=$_POST['payroll_basicsalary'];

//leaveline
$o->leaveline_id=$_POST['leaveline_id'];
$o->leaveline_qty=$_POST['leaveline_qty'];
$o->leaveline_amount=$_POST['leaveline_amount'];

//allowanceline
$o->allowanceline_id=$_POST['allowanceline_id'];
$o->allowancepayroll_id=$_POST['allowancepayroll_id'];
$o->allowancepayroll_amount=$_POST['allowancepayroll_amount'];

$isactive=$_POST['isactive'];
$issocsoot=$_POST['issocsoot'];
$isepfot=$_POST['isepfot'];
$iscomplete=$_POST['iscomplete'];

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

$o->datectrl=$dp->show("payroll_date");

//showTable
$o->fldShow = $_POST["fldShow"];

//search date
$o->start_date=$_POST["start_date"];
$o->end_date=$_POST["end_date"];
$o->startctrl=$dp->show("start_date");
$o->endctrl=$dp->show("end_date");


if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
elseif($isactive=="X")
	$o->isactive='X';
else
	$o->isactive='N';

if ($iscomplete=="Y" or $iscomplete=="on")
	$o->iscomplete='Y';
elseif($iscomplete=="X")
	$o->iscomplete='X';
else
	$o->iscomplete='N';

if ($issocsoot=="Y" or $issocsoot=="on")
	$o->issocsoot='Y';
else
	$o->issocsoot='N';

if ($isepfot=="Y" or $isepfot=="on")
	$o->isepfot='Y';
else
	$o->isepfot='N';

  			
			
 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with payroll name=$o->payroll_name");

	if ($s->check(false,$token,"CREATE_CAT")){
		
		

	if($o->insertPayroll()){
		 $latest_id=$o->getLatestPayrollID();

		if($o->iscomplete=="Y"){
		$token=$s->createToken($tokenlife,"CREATE_CAT");
		$o->employeectrl=$e->getEmployeeList(0,"","employee_id","getAllowance(this.value);");
		$o->getInputForm("new",0,$token);
		echo "<script type='text/javascript'>PopupCenter('payslip.php?payroll_id=$latest_id', 'Pay Slip',1000,800);</script>";
		
		}else{
		redirect_header("payroll.php?action=edit&payroll_id=$latest_id",$pausetime,"Your data is saved.");
		}

		//	 redirect_header("payroll.php?action=edit&payroll_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create payroll!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_CAT");
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id","getAllowance(this.value);");
		$o->getInputForm("new",-1,$token);
		$o->showPayrollTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchPayroll($o->payroll_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_CAT"); 
		//$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->employeectrl=$e->getEmployeeList($o->employee_id,"","employee_id","getAllowance(this.value);");
		$o->getInputForm("edit",$o->payroll_id,$token);
		//$o->showPayrollTable(); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("payroll.php",3,"Some error on viewing your payroll data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	
	if ($s->check(false,$token,"CREATE_CAT")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updatePayroll()){ //if data save successfully
			if($o->iscomplete=="Y"){
			$token=$s->createToken($tokenlife,"CREATE_CAT");
			$o->employeectrl=$e->getEmployeeList(0,"","employee_id","getAllowance(this.value);");
			$o->getInputForm("new",0,$token);
 			echo "<script type='text/javascript'>PopupCenter('payslip.php?payroll_id=$o->payroll_id', 'Pay Slip',1000,800);</script>";
			
			}else{
			redirect_header("payroll.php?action=edit&payroll_id=$o->payroll_id",$pausetime,"Your data is saved.");
			}
		}else{
			redirect_header("payroll.php?action=edit&payroll_id=$o->payroll_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	}else{
		redirect_header("payroll.php?action=edit&payroll_id=$o->payroll_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CAT")){
		if($o->deletePayroll($o->payroll_id))
			redirect_header("payroll.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("payroll.php?action=edit&payroll_id=$o->payroll_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("payroll.php?action=edit&payroll_id=$o->payroll_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

 case "search" :
	//$o->customerctrl=$t->getSelectCustomer(0);
	$o->employeectrl=$e->getEmployeeList(0,"","employee_id","getAllowance(this.value);");

	//$o->productctrl=$p->getSelectProduct(0);
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	//$o->getInputForm("new",0,$token);
	$o->showPayrollTable();

  break;

  case "getallowance":
	
	$basic_salary = $o->getEmployeeDetail($_POST['employee_id'],"basic_salary");
	$totalallowance = $o->getTotalAllowancePayroll();
	$commission = $o->getCommission($_POST['employee_id']);

	$totalPay = $basic_salary + $totalallowance;


	//echo "<script type='text/javascript'>self.parent.document.forms['frmPayroll'].total_allowance.value='$total_allowance';</script>";
	echo "<script type='text/javascript'>self.parent.document.forms['frmPayroll'].payroll_amt_comm.value='$commission';</script>";
	echo "<script type='text/javascript'>updateAllowanceRM('$basic_salary');</script>";
//	echo "<script type='text/javascript'>self.parent.updateBaseAllowance(self.parent.document);</script>";
	
	echo "<script type='text/javascript'>calculateTotal('$totalPay',1,'');</script>";
	

  break;

  case "getamount":


	$totalallowance = $o->getTotalAllowancePayroll($_POST['payroll_id']);
	$totalleave = $o->getTotalLeavePayroll($_POST['payroll_id']);
	//$basic_salary = $o->getEmployeeDetail($_POST['employee_id'],"basic_salary");
	$basic_salary = $_POST['basic_salary'];
	$thisname = $_POST['thisname'];
		
	$totalPay = $basic_salary + $totalallowance - $totalleave;

	echo "<script type='text/javascript'>self.parent.updateBase(self.parent.document);</script>";
	echo "<script type='text/javascript'>calculateTotal('$totalPay',2,'$thisname');</script>";



	

  break;


  case "getamountfrm":
	
	$totalallowance = $o->getTotalAllowancePayroll($_POST['payroll_id']);
	$totalleave = $o->getTotalLeavePayroll($_POST['payroll_id']);

	//$basic_salary = $o->getEmployeeDetail($_POST['employee_id'],"basic_salary");
	$basic_salary = $_POST['basic_salary'];
	$thisname = $_POST['thisname'];
		
	$totalPay = $basic_salary + $totalallowance - $totalleave;

//	echo "<script type='text/javascript'>alert('');</script>";
	echo "<script type='text/javascript'>self.parent.updateBase(self.parent.document);</script>";
	echo "<script type='text/javascript'>calculateTotal('$totalPay',1,'$thisname');</script>";

  break;

  case "updatebase":
	
	$totalAllowanceEPF = $o->getTotalAllowanceBase("allowancepayroll_epf",$_POST['payroll_id']);
	$totalAllowanceSOCSO = $o->getTotalAllowanceBase("allowancepayroll_socso",$_POST['payroll_id']);
	
	//$basic_salary = $o->getEmployeeDetail($_POST['employee_id'],"basic_salary");
	$basic_salary = $_POST['basic_salary'];

	$commission = $_POST['payroll_amt_comm'];

	$baseEPF = $totalAllowanceEPF + $basic_salary + $commission;
	$baseSOCSO = $totalAllowanceSOCSO + $basic_salary + $commission;

	$ot_socso = $_POST['ot_socso'];
	$ot_epf = $_POST['ot_epf'];

//	echo "<script type='text/javascript'>alert('');</script>";
	echo "<script type='text/javascript'>calculateBase('$baseEPF','$ot_epf','epf');</script>";
	echo "<script type='text/javascript'>calculateBase('$baseSOCSO','$ot_socso','socso');</script>";
	echo "<script type='text/javascript'>self.parent.updateSocsoEpf(self.parent.document);</script>";


  break;
  
  case "updatesocsoepf":

	
  	$socsoemployee = $o->getSocsoEPF($_POST['socso_base'],"socso_employee");
	$socsoemployer = $o->getSocsoEPF($_POST['socso_base'],"socso_employer");
	$epfemployee = $o->getSocsoEPF($_POST['epf_base'],"epf_employee");
	$epfemployer = $o->getSocsoEPF($_POST['epf_base'],"epf_employer");
	
//	echo "<script type='text/javascript'>alert('$epf_base');</script>";

	echo "<script type='text/javascript'>self.parent.document.forms['frmPayroll'].payroll_socsoemployee.value='$socsoemployee';</script>";
	echo "<script type='text/javascript'>self.parent.document.forms['frmPayroll'].payroll_socsoemployer.value='$socsoemployer';</script>";
	echo "<script type='text/javascript'>self.parent.document.forms['frmPayroll'].payroll_epfemployee.value='$epfemployee';</script>";
	echo "<script type='text/javascript'>self.parent.document.forms['frmPayroll'].payroll_epfemployer.value='$epfemployer';</script>";
	
  break;


  case "getamount2":
	
	//$basic_salary = $o->getEmployeeDetail($_POST['employee_id'],"basic_salary");
	$basic_salary = $_POST['basic_salary'];
	$thisobject = $_POST['thisobject'];

	//echo "<script type='text/javascript'>alert('$thisname');</script>";
	echo "<script type='text/javascript'>self.parent.updateBase(self.parent.document);</script>";
	echo "<script type='text/javascript'>calculateTotal('$basic_salary',0,'$thisobject');</script>";

  break;


  case "checkemployee":
	
	$employee_id = $_POST['employee_id'];
	$monthof = $_POST['monthof'];
	$yearof = $_POST['yearof'];

	$retval = $o->checkEmployee($employee_id,$monthof,$yearof);
	
	if($retval["count"] > 0 )
	$cnt = "1";
	else
	$cnt = "0";

	if($retval["count"] > 0 ){
	$payroll_id = $retval["payroll_id"];
	echo "<script type='text/javascript'>alert('Duplicate Record. Please Select Correct Month & Year');</script>";
	echo "<script type='text/javascript'>parent.duplicateUrl('$payroll_id') ;</script>";
	}else{
	echo "<script type='text/javascript'>self.parent.document.forms['frmPayroll'].submit();</script>";
	}

  break;

  case "enable" :
	
	if($o->enablePayroll()) {
	redirect_header("payroll.php?action=edit&payroll_id=$o->payroll_id",$pausetime,"Your data is enabled.");
	}else{
	redirect_header("payroll.php?action=edit&payroll_id=$o->payroll_id",$pausetime,"Warning! Can't enable the data!");
	}	
	
  
  break;

  case "gotourl" :
	
	//$o->customerctrl=$t->getSelectCustomer(0);
	$o->employeectrl=$e->getEmployeeList(0,"","employee_id","getAllowance(this.value);");

	//$o->productctrl=$p->getSelectProduct(0);
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	//$o->getInputForm("new",0,$token);
	$o->showPayrollTable();
  break;

  default :

	$token=$s->createToken($tokenlife,"CREATE_CAT");
	$o->employeectrl=$e->getEmployeeList(0,"","employee_id","getAllowance(this.value);");
	//$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->getInputForm("new",0,$token);
	//$o->showPayrollTable();
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

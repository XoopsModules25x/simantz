<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Terms.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Terms($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function onOpen(){
	document.forms['frmTerms'].terms_code.focus();
	}

	function validateTerms2(){
		var code=document.forms['frmTerms'].terms_code.value;
		var desc=document.forms['frmTerms'].terms_desc.value;
		
		if(code =="" || desc==""){
			alert('Please make sure terms code and terms description is filled in.');
			return false;
		}
		else
			return true;
	}
	
	function IsNumeric(sText){
	
   var ValidChars = "0123456789.";
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
      
      
      if(sText=="")
	IsNumber = false;


   return IsNumber;
   
   }



	

	function validateTerms(){
 	
 	if(confirm('Confirm change this data?')==false){
  	return false;
  	}else{
  	
  	var code=document.forms['frmTerms'].terms_code.value;
		var desc=document.forms['frmTerms'].terms_desc.value;
		
		if(code =="" || desc==""){
			alert('Please make sure terms code and terms description is filled in.');
			return false;
		}
	
		
  	var i=0;
  	while(i< document.forms['frmTerms'].elements.length){
		var ctlname = document.forms['frmTerms'].elements[i].name; 
		var data = document.forms['frmTerms'].elements[i].value;

		if(ctlname=="terms_days"){
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmTerms'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmTerms'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmTerms'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
		}	
		 	i++;
	 	
 	}		
 	 
		return true;
	}
	
	}
	
	

	function headerSort(sortFldValue){

		document.frmActionSearch.fldSort.value = sortFldValue;

		//document.frmActionSearch.btnSubmit.click();
		document.frmActionSearch.submit();

	}
</script>

EOF;

$o->terms_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->terms_id=$_POST["terms_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->terms_id=$_GET["terms_id"];

}
else
$action="";

$token=$_POST['token'];

//================

$o->terms_code=$_POST["terms_code"];
$o->terms_desc=$_POST["terms_desc"];
$o->terms_days=$_POST["terms_days"];
$o->created=$_POST["created"];
$o->updated=$_POST["updated"];
$o->isactive=$_POST["isactive"];


//==================


$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');


if ($o->isactive=="on")
	$o->isactive=1;
elseif($o->isactive=="")
	$o->isactive=0;

/*
if ($isdefault=="1" or $isdefault=="on")
	$o->isdefault=1;
else
	$o->isdefault=0;
	*/

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Terms Master Data</span></big></big></big></div><br>
EOF;
$filterstring=$o->searchAToZ();

if($_GET['filterstring'] != "")
	$filterstring=$_GET['filterstring'];
 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with terms name=$o->terms_desc");

	if ($s->check(false,$token,"CREATE_CAT")){
		
	if($o->insertTerms()){
		 $latest_id=$o->getLatestTermsID();
			 redirect_header("terms.php?action=edit&terms_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				//echo "Can't create terms!";
				redirect_header("terms.php?action=new",3,"<b style='color:red'>Can't create terms!</b>");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_CAT");
		$o->getInputForm("new",-1,$token);
		$o->showTermsTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchTerms($o->terms_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_CAT");
		$o->termsctrl=$o->getSelectTerms(-1);
		$o->getInputForm("edit",$o->terms_id,$token);
		
//		$wc->showTermsEmploymentTable("WHERE wc.terms_id=$o->terms_id","order by wc.terms_desc ",0,99999); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("terms.php",3,"Some error on viewing your terms data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_CAT")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateTerms()) //if data save successfully
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Your data is saved.");
		else
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CAT")){
		if($o->deleteTerms($o->terms_id))
			redirect_header("terms.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("terms.php?action=edit&terms_id=$o->terms_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :
	$token=$s->createToken($tokenlife,"CREATE_CAT");
	$o->termsctrl=$o->getSelectTerms(-1);
	$o->getInputForm("new",0,$token);
	
	//$o->showTermsTable("WHERE c.isactive=1","order by c.terms_desc",0,99999);
  break;
  case "showSearchForm":
	$o->termsctrl=$o->getSelectTerms(-1);
	//$o->termsctrl=$o->getSelectTerms(-1);

	$o->showSearchForm();
  break;
  case "search":
  
  $sortstr = "ORDER BY c.terms_desc";
  $wherestr=$o->convertSearchString($o->terms_id,$o->terms_code,$o->terms_desc,$o->isactive);
  $fldSort = '';
  
  
	// start sort header
	
	
	if($_POST['fldSort']!=''){
	$fldSort = $_POST['fldSort'];
	$wherestr = str_replace('\\', '',$_POST['wherestr']);
	$orderctrl = $_POST['orderctrl'];
	$sortstr = " order by ".$fldSort." ".$orderctrl;
	}
		
	if($orderctrl ==''){
	$orderctrl = "desc";
	}else{
	
		if($orderctrl =='asc'){
		$orderctrl = "desc";
		}else{
		$orderctrl = "asc";
		}		
	
	}
	
	//end of sort
	
	
	$o->termsctrl=$o->getSelectTerms(-1);
	//$o->termsctrl=$o->getSelectTerms(-1);
	
	$log->showLog(4,"Filterstring:$o->terms_id,$o->terms_code,$o->terms_desc,$o->isactive");
	$o->showSearchForm("$wherestr","$orderctrl");
	
	$o->showSearchTable("$wherestr","$sortstr",0,9999,"$orderctrl","$fldSort");
	
	//$o->showSearchTable($wherestring,"ORDER BY c.terms_desc",0,9999);
	
  break;
  default :
//	$token=$s->createToken(120,"CREATE_CAT");
//	$o->getInputForm("new",0,$token);
//	$o->currencyctrl=$cr->getSelectCurrency(0);
	if ($filterstring=="")
		$filterstring="A";
	$o->showTermsTable("WHERE c.isactive=1","order by c.terms_days",0,99999);
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


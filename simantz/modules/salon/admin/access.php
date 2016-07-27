<?php
include_once "system.php" ;
include_once '../class/Log.php';
include_once 'class/Access.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

xoops_cp_header();

$log = new Log();
$o = new Access($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);


$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function selectAll(type){
	
	var i=0;
  	while(i< document.forms['frmAccess'].elements.length){
		var ctlname = document.forms['frmAccess'].elements[i].name; 
		var data = document.forms['frmAccess'].elements[i].value;

		if(ctlname.substring(0,8)=="allowadd" || ctlname.substring(0,9)=="allowedit" || ctlname.substring(0,15)=="isaccesswindows" ){	

		if(type==1)
		document.forms['frmAccess'].elements[i].checked = false;
		else
		document.forms['frmAccess'].elements[i].checked = true;	
				
		}	
	i++;
	 	
 	}

	}

	function saveGroup(){
	
	if(confirm('Confirm change this data?')==false){
  	return false;
  	}else{
	document.forms['frmAccess'].action.value = "save";
	document.forms['frmAccess'].submit();
	}

	}

	function showChildGroup(){

	var group=document.forms['frmAccess'].groupid.value;
	
	if(group<1){
	alert("Please Select User Group!");
	}else{
	document.forms['frmAccess'].action.value = "edit";
	document.forms['frmAccess'].submit();
	}

	}


	function onOpen(){
	document.forms['frmAccess'].access_no.focus();
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


	

	function validateAccess(){
 	
 	if(confirm('Confirm change this data?')==false){
  	return false;
  	}else{
  	
  	var code=document.forms['frmAccess'].access_no.value;
		var desc=document.forms['frmAccess'].access_name.value;
		
		if(code =="" || desc==""){
			alert('Please make sure access code and access description is filled in.');
			return false;
		}
	
		
  	var i=0;
  	while(i< document.forms['frmAccess'].elements.length){
		var ctlname = document.forms['frmAccess'].elements[i].name; 
		var data = document.forms['frmAccess'].elements[i].value;

		if(ctlname=="access_amount" || ctlname=="access_cost" ){
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmAccess'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmAccess'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmAccess'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
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

$o->groupid=0;

if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->groupid=$_POST["groupid"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->groupid=$_GET["groupid"];

}
else
$action="";




$token=$_POST['token'];

//================

//$o->access_no=$_POST["access_no"];



$o->branchgroupline_id=$_POST["branchgroupline_id"];
$o->branch_id=$_POST["branch_id"];
$o->isaccessbranch=$_POST["isaccessbranch"];
$o->deptgroupline_id=$_POST["deptgroupline_id"];
$o->dept_id=$_POST["dept_id"];
$o->isaccessdept=$_POST["isaccessdept"];
$o->windowsgroupline_id=$_POST["windowsgroupline_id"];
$o->windows_id=$_POST["windows_id"];
$o->isaccesswindows=$_POST["isaccesswindows"];
$o->windows_no=$_POST["windows_no"];
$o->allowadd=$_POST["allowadd"];
$o->allowedit=$_POST["allowedit"];
$o->access_grouptype=$_POST["access_grouptype"];


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
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Access Control</span></big></big></big></div><br>
EOF;
$filterstring=$o->searchAToZ();

if($_GET['filterstring'] != "")
	$filterstring=$_GET['filterstring'];
 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with access name=$o->access_name");

	if ($s->check(false,$token,"CREATE_ITEM")){
		
	if($o->insertAccess()){

		 $latest_id=$o->getLatestAccessID();
			 redirect_header("access.php?action=edit&access_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				
				redirect_header("access.php?action=new",3,"<b style='color:red'>Can't create access!</b>");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_ITEM");
		$o->getInputForm("new",-1,$token);
		$o->showAccessTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	
	if($o->groupid!=0){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ITEM");
		$o->groupctrl=$o->getSelectGroup($o->groupid,"groupid","showChildGroup()");
		$o->getInputForm("edit",$o->access_id,$token);
		
//		$wc->showAccessEmploymentTable("WHERE wc.access_id=$o->access_id","order by wc.access_name ",0,99999); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("access.php",3,"Some error on viewing your access data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ITEM")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateAccess()) //if data save successfully
			redirect_header("access.php?action=edit&access_id=$o->access_id",$pausetime,"Your data is saved.");
		else
			redirect_header("access.php?action=edit&access_id=$o->access_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("access.php?action=edit&access_id=$o->access_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ITEM")){
		if($o->deleteAccess($o->access_id))
			redirect_header("access.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("access.php?action=edit&access_id=$o->access_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("access.php?action=edit&access_id=$o->access_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :
	$token=$s->createToken($tokenlife,"CREATE_ITEM");
//	$o->categoryctrl=$o->getSelectCategory(0);
	$o->getInputForm("new",0,$token);
	
	//$o->showAccessTable("WHERE c.isactive=1","order by c.access_name",0,99999);
  break;
  case "showSearchForm":
	$o->accessctrl=$o->getSelectAccess(-1);
//	$o->categoryctrl=$o->getSelectCategory(-1);

	$o->showSearchForm();
  break;
  case "search":
  
  
  $sortstr = "ORDER BY c.access_name";
  $wherestr=$o->convertSearchString($o->access_id,$o->access_no,$o->access_name,$o->isactive,$o->category_id);
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
	
	
	$o->accessctrl=$o->getSelectAccess(-1);
//	$o->categoryctrl=$o->getSelectCategory(-1);
	
	$log->showLog(4,"Filterstring:$o->access_id,$o->access_no,$o->access_name,$o->isactive");
	$o->showSearchForm("$wherestr","$orderctrl");
	
	$o->showSearchTable("$wherestr","$sortstr",0,9999,"$orderctrl","$fldSort");
	
	//$o->showSearchTable($wherestring,"ORDER BY c.access_name",0,9999);
	
  break;

 //when user press save for change existing organization data
  case "save" :
	if ($s->check(false,$token,"CREATE_ITEM")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid

		if($o->updateGroup()) //if data save successfully
			redirect_header("access.php?action=edit&groupid=$o->groupid",$pausetime,"Your data is saved.");
		else
			redirect_header("access.php?action=edit&groupid=$o->groupid",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("access.php?action=edit&access_id=$o->access_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;

  default :
	$token=$s->createToken($tokenlife,"CREATE_ITEM");
	$o->groupctrl=$o->getSelectGroup(-1,"groupid","showChildGroup()");
	$o->getInputForm("new",0,$token);
  break;

}

echo '</td>';
xoops_cp_footer();

?>


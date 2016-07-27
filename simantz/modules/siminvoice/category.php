<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Category.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Category($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">

	function onOpen(){
	document.forms['frmCategory'].category_code.focus();
	}

	function validateCategory(){
		var code=document.forms['frmCategory'].category_code.value;
		var desc=document.forms['frmCategory'].category_desc.value;
		
		if(confirm('Confirm change this data?')==false){
  		return false;
  		}else{
  		
		if(code =="" || desc==""){
			alert('Please make sure category code and category description is filled in.');
			return false;
		}
		else
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

$o->category_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->category_id=$_POST["category_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->category_id=$_GET["category_id"];

}
else
$action="";

$token=$_POST['token'];

//================

$o->category_code=$_POST["category_code"];
$o->category_desc=$_POST["category_desc"];
$o->category_type=$_POST["category_type"];
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
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Category Master Data</span></big></big></big></div><br>
EOF;
$filterstring=$o->searchAToZ();

if($_GET['filterstring'] != "")
	$filterstring=$_GET['filterstring'];
 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with category name=$o->category_desc");

	if ($s->check(false,$token,"CREATE_CAT")){
		
	if($o->insertCategory()){
		 $latest_id=$o->getLatestCategoryID();
			 redirect_header("category.php?action=edit&category_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				
				redirect_header("category.php?action=new",3,"<b style='color:red'>Can't create category!</b>");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_CAT");
		$o->getInputForm("new",-1,$token);
		$o->showCategoryTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchCategory($o->category_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_CAT");
		$o->categoryctrl=$o->getSelectCategory(-1);
		$o->getInputForm("edit",$o->category_id,$token);
	$o->showCategoryTable("WHERE c.isactive=1 and c.category_id <> 0 ","order by c.category_desc",0,99999);		
//		$wc->showCategoryEmploymentTable("WHERE wc.category_id=$o->category_id","order by wc.category_desc ",0,99999); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("category.php",3,"Some error on viewing your category data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_CAT")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateCategory()) //if data save successfully
			redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Your data is saved.");
		else
			redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
	$o->showCategoryTable("WHERE c.isactive=1 and c.category_id <> 0 ","order by c.category_desc",0,99999);
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_CAT")){
		if($o->deleteCategory($o->category_id))
			redirect_header("category.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("category.php?action=edit&category_id=$o->category_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :
	$token=$s->createToken($tokenlife,"CREATE_CAT");
	$o->categoryctrl=$o->getSelectCategory(-1);
	$o->getInputForm("new",0,$token);
	
	$o->showCategoryTable("WHERE c.isactive=1  and c.category_id <> 0 ","order by c.category_desc",0,99999);
  break;
  case "showSearchForm":
	$o->categoryctrl=$o->getSelectCategory(-1);
	//$o->categoryctrl=$o->getSelectCategory(-1);

	$o->showSearchForm();
  break;
  case "search":
  
  $sortstr = "ORDER BY c.category_desc";
  $wherestr=$o->convertSearchString($o->category_id,$o->category_code,$o->category_desc,$o->isactive,$o->category_type);
  $fldSort = '';
  
  
	// start sort header
	
	
	if($_POST['fldSort']!=''){
	$fldSort = $_POST['fldSort'];
	$wherestr = str_replace('\\', '',$_POST['wherestr']);
	$orderctrl = $_POST['orderctrl'];
	$sortstr = " order by ".$fldSort." ".$orderctrl;
	}else{
	
	if($wherestr!='')
	$wherestr .= " and c.category_id <> 0 ";
	else
	$wherestr .= " where c.category_id <> 0 ";
	
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
	
	
	$o->categoryctrl=$o->getSelectCategory(-1);
	//$o->categoryctrl=$o->getSelectCategory(-1);
	
	$log->showLog(4,"Filterstring:$o->category_id,$o->category_code,$o->category_desc,$o->isactive");
	$o->showSearchForm("$wherestr","$orderctrl");
	
	$o->showSearchTable("$wherestr","$sortstr",0,9999,"$orderctrl","$fldSort");
	
	//$o->showSearchTable($wherestring,"ORDER BY c.category_desc",0,9999);
	
  break;
  default :
//	$token=$s->createToken(120,"CREATE_CAT");
//	$o->getInputForm("new",0,$token);
//	$o->currencyctrl=$cr->getSelectCurrency(0);
//	if ($filterstring=="")
//		$filterstring="A";
		
	$o->showCategoryTable("WHERE c.isactive=1  and c.category_id <> 0 ","order by c.category_desc",0,99999);
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


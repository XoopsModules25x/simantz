<?php
include_once "system.php" ;
include_once 'class/Log.php';
include_once 'class/Item.php';
include_once "menu.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Item($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
//$e = new Employee($xoopsDB,$tableprefix,$log);

$orgctrl="";


$action="";

echo <<< EOF
<script type="text/javascript">


	function onOpen(){
	document.forms['frmItem'].item_code.focus();
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



	function validateItem2(){
		
	}
	
	

	function validateItem(){
 	
 	if(confirm('Confirm change this data?')==false){
  	return false;
  	}else{
  	
  	var code=document.forms['frmItem'].item_code.value;
		var desc=document.forms['frmItem'].item_desc.value;
		
		if(code =="" || desc==""){
			alert('Please make sure item code and item description is filled in.');
			return false;
		}
	
		
  	var i=0;
  	while(i< document.forms['frmItem'].elements.length){
		var ctlname = document.forms['frmItem'].elements[i].name; 
		var data = document.forms['frmItem'].elements[i].value;

		if(ctlname=="item_amount" || ctlname=="item_cost" ){
			if(!IsNumeric(data))
				{
					alert (ctlname + ":" + data + ":is not numeric, please insert appropriate +ve value!");
					document.forms['frmItem'].elements[i].style.backgroundColor = "#FF0000";
					document.forms['frmItem'].elements[i].focus();
					return false;
				}	
				else
				document.forms['frmItem'].elements[i].style.backgroundColor = "#FFFFFF";
				
				
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

$o->item_id=0;

if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->item_id=$_POST["item_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->item_id=$_GET["item_id"];

}
else
$action="";

//echo $o->item_id;

$token=$_POST['token'];

//================

$o->item_code=$_POST["item_code"];
$o->item_desc=$_POST["item_desc"];
$o->category_id=$_POST["category_id"];
$o->item_amount=$_POST["item_amount"];
$o->item_uom=$_POST["item_uom"];
$o->item_cost=$_POST["item_cost"];
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
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Item Master Data</span></big></big></big></div><br>
EOF;
$filterstring=$o->searchAToZ();

if($_GET['filterstring'] != "")
	$filterstring=$_GET['filterstring'];
 switch ($action){

	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with item name=$o->item_desc");

	if ($s->check(false,$token,"CREATE_ITEM")){
		
	if($o->insertItem()){

		 $latest_id=$o->getLatestItemID();
			 redirect_header("item.php?action=edit&item_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				
				redirect_header("item.php?action=new",3,"<b style='color:red'>Can't create item!</b>");
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_ITEM");
		$o->getInputForm("new",-1,$token);
		$o->showItemTable(); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :

	if($o->fetchItem($o->item_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_ITEM");
		$o->categoryctrl=$o->getSelectCategory($o->category_id);
		$o->getInputForm("edit",$o->item_id,$token);
		
//		$wc->showItemEmploymentTable("WHERE wc.item_id=$o->item_id","order by wc.item_desc ",0,99999); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("item.php",3,"Some error on viewing your item data, probably database corrupted");
  
break;

//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_ITEM")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateItem()) //if data save successfully
			redirect_header("item.php?action=edit&item_id=$o->item_id",$pausetime,"Your data is saved.");
		else
			redirect_header("item.php?action=edit&item_id=$o->item_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("item.php?action=edit&item_id=$o->item_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_ITEM")){
		if($o->deleteItem($o->item_id))
			redirect_header("item.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("item.php?action=edit&item_id=$o->item_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("item.php?action=edit&item_id=$o->item_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "new" :
	$token=$s->createToken($tokenlife,"CREATE_ITEM");
	$o->categoryctrl=$o->getSelectCategory(0);
	$o->getInputForm("new",0,$token);
	
	//$o->showItemTable("WHERE c.isactive=1","order by c.item_desc",0,99999);
  break;
  case "showSearchForm":
	$o->itemctrl=$o->getSelectItem(-1);
	$o->categoryctrl=$o->getSelectCategory(-1);

	$o->showSearchForm();
  break;
  case "search":
  
  
  $sortstr = "ORDER BY c.item_desc";
  $wherestr=$o->convertSearchString($o->item_id,$o->item_code,$o->item_desc,$o->isactive,$o->category_id);
  $fldSort = '';
  
  
	// start sort header
	
	
	if($_POST['fldSort']!=''){
	$fldSort = $_POST['fldSort'];
	$wherestr = str_replace('\\', '',$_POST['wherestr']);
	$orderctrl = $_POST['orderctrl'];
	$sortstr = " order by ".$fldSort." ".$orderctrl;
	}else{//if have join table add here
	
	if($wherestr!='')
	$wherestr .= " and a.category_id = c.category_id and c.item_id <> 0 ";
	else
	$wherestr .= " where a.category_id = c.category_id and c.item_id <> 0 ";
	
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
	
	
	$o->itemctrl=$o->getSelectItem(-1);
	$o->categoryctrl=$o->getSelectCategory(-1);
	
	$log->showLog(4,"Filterstring:$o->item_id,$o->item_code,$o->item_desc,$o->isactive");
	$o->showSearchForm("$wherestr","$orderctrl");
	
	$o->showSearchTable("$wherestr","$sortstr",0,9999,"$orderctrl","$fldSort");
	
	//$o->showSearchTable($wherestring,"ORDER BY c.item_desc",0,9999);
	
  break;
  default :
//	$token=$s->createToken(120,"CREATE_ITEM");
//	$o->getInputForm("new",0,$token);
//	$o->currencyctrl=$cr->getSelectCurrency(0);
	if ($filterstring=="")
		$filterstring="A";
		
	$o->showItemTable("WHERE c.item_desc LIKE '$filterstring%' and c.isactive=1 and c.category_id = a.category_id and c.item_code <> '0' ","order by c.item_desc",0,99999);
  break;

}

echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>


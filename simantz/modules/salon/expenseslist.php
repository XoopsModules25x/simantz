<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Log.php';
include_once 'class/Expenseslist.php';
include_once 'class/Uom.php';
include_once 'class/Employee.php';
include_once 'class/Expensescategory.php';
require ("datepicker/class.datepicker.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$dp=new datepicker("$tableprefix");
$dp->dateFormat='Y-m-d';
$log = new Log();
$o = new Expenseslist($xoopsDB,$tableprefix,$log);
$c = new Expensescategory($xoopsDB,$tableprefix,$log);

$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);
$e = new Employee($xoopsDB,$tableprefix,$log);
$u = new Uom($xoopsDB,$tableprefix,$log);

$o->orgctrl="";
$o->categoryctrl="";


$action="";

echo <<< EOF
<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Expenses List</span></big></big></big></div><br>

<script type="text/javascript">

	function searchExpenseslist(){//searching
		document.forms['frmSearch'].action.value = "search";
		document.forms['frmSearch'].fldShow.value = "Y";
		document.forms['frmSearch'].submit();
	}

	function showSearch(){//show search form
		document.forms['frmExpenseslist'].action.value = "search";
		document.forms['frmExpenseslist'].fldShow.value = "Y";
		document.forms['frmExpenseslist'].submit();
		
	}

	function autofocus(){
	document.forms['frmExpenseslist'].expenseslist_name.focus();
	}

	
	function tableFilter(category_id){
	document.forms['frmATZ'].filterstring.value = category_id;
	document.forms['frmATZ'].submit();
	}

	function validateExpenseslist(){
		var name=document.forms['frmExpenseslist'].expenseslist_name.value;
		var code=document.forms['frmExpenseslist'].expenseslist_no.value;
		var amt=document.forms['frmExpenseslist'].amt.value;

		
		if(confirm("Save Record?")){
		if(name =="" || code==""|| !IsNumeric(amt)){
			alert('Please make sure Expenseslist no and name is filled in, Amount filled with number.');
			return false;
		}
		else
			return true;
		}
		else
			return false;
	}
</script>

EOF;


if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->expenseslist_id=$_POST["expenseslist_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->expenseslist_id=$_GET["expenseslist_id"];

}
else
$action="";
$token=$_POST['token'];
$o->expenseslist_name=$_POST["expenseslist_name"];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;	

$o->expenseslist_no=$_POST["expenseslist_no"];
$o->organization_id=$_POST["organization_id"];
$o->amt=$_POST['amt'];
$o->isAdmin=$xoopsUser->isAdmin();
$o->category_id=$_POST['category_id'];
$o->uom_id=$_POST['uom_id'];
$o->description=$_POST['description'];
$o->remarks=$_POST['remarks'];
$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->deleteAttachment=$_POST['deleteAttachment'];
$tmpfile= $_FILES["upload_file"]["tmp_name"];
$filesize=$_FILES["upload_file"]["size"] / 1024;
$filetype=$_FILES["upload_file"]["type"];
$filename=$_FILES["upload_file"]["name"];
if($filename!="")
$withfile='Y';
else
$withfile='N';

$file_ext = strrchr($filename, '.');
$o->filename=$o->expenseslist_id.$file_ext;
$newfilename=$o->expenseslist_id.$file_ext;

$o->fldShow = $_POST["fldShow"];
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

if($_POST['filterstring']!="")
$o->filterstring = $_POST['filterstring'];
else
$o->filterstring = 0;
//$o->filterstring = $o->getFirstCategory();

if($o->category_id=="")
$o->category_id=0;

 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired


	if ($s->check(false,$token,"CREATE_EXP")){
		$log->showLog(4,"Accessing create record event, with product name=$o->expenseslist_name");
		if($o->insertExpenseslist()){
			$latest_id=$o->getLatestExpenseslistID();
			if($filesize>0 || $filetype=='application/pdf')
			$o->savefile($tmpfile);
			redirect_header("expenseslist.php?action=edit&expenseslist_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
				echo "Can't create product!";
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$token=$s->createToken($tokenlife,"CREATE_EXP");
		$o->categoryctrl=$c->getSelectCategory($o->category_id);
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->uomctrl=$u->getSelectUom($o->uom_id);
		$o->getInputForm("new",-1,$token);
		$o->showExpenseslistTable($o->category_id,$c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'")); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchExpenseslistInfo($o->expenseslist_id)){
		$o->searchAToZ($c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'"));
		$o->orgctrl=$e->selectionOrg($o->createdby,$o->organization_id);
		$o->categoryctrl=$c->getSelectCategory($o->category_id);
		$o->uomctrl=$u->getSelectUom($o->uom_id);
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_EXP"); 
		$o->getInputForm("edit",$o->expenseslist_id,$token);
		$o->showExpenseslistTable($o->category_id,$c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'")); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("expenseslist.php",3,"Some error on viewing your product data, probably database corrupted");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_EXP")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateExpenseslist($withfile)) {
			//if data save successfully
			//
			if($o->deleteAttachment=='on')
				$o->deletefile($o->expenseslist_id);
			
			if($filesize>0)
				$o->savefile($tmpfile,$newfilename);
		
			redirect_header("expenseslist.php?action=edit&expenseslist_id=$o->expenseslist_id",$pausetime,"Your data is saved.");
		}
		else
			redirect_header("expenseslist.php?action=edit&expenseslist_id=$o->expenseslist_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
		}
	else{
		redirect_header("expenseslist.php?action=edit&expenseslist_id=$o->expenseslist_id",$pausetime,"Warning! Can't save the data, please make sure all value is insert properly.");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_EXP")){
		if($o->deleteExpenseslist($o->expenseslist_id)){
			redirect_header("expenseslist.php",$pausetime,"Data removed successfully.");
			$o->deletefile($o->expenseslist_id);
		}
		else
			redirect_header("expenseslist.php?action=edit&expenseslist_id=$o->expenseslist_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("expenseslist.php?action=edit&expenseslist_id=$o->expenseslist_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;

  case "search" :
	//$o->searchAToZ($c->getSelectCategory($o->filterstring,"onchange='tableFilter(this.value)'"));
	//$token=$s->createToken($tokenlife,"CREATE_EXP");
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->categoryctrl=$c->getSelectCategory(0);
	$o->uomctrl=$u->getSelectUom(0);
	//$o->showExpenseslistTable();
	$o->showExpenseslistTable($o->filterstring,$c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'"));
  break;
	

  default :
	
	$o->searchAToZ($c->getSelectCategory($o->filterstring,"onchange='tableFilter(this.value)'"));
	$token=$s->createToken($tokenlife,"CREATE_EXP");
	$o->orgctrl=$e->selectionOrg($o->createdby,0);
	$o->categoryctrl=$c->getSelectCategory(0);
	$o->uomctrl=$u->getSelectUom(0);
	$o->getInputForm("new",0,$token);
	$o->showExpenseslistTable($o->filterstring,$c->getSelectCategory($o->category_id,"onchange='tableFilter(this.value)'"));
  break;

}
echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

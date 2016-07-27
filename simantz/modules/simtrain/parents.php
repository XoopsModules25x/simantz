<?php
include_once "system.php" ;
include_once "menu.php";
include_once 'class/Parents.php';
include_once 'class/Log.php';
$log = new Log();

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);


$o = new Parents($xoopsDB,$tableprefix,$log);
$s = new XoopsSecurity($xoopsDB,$tableprefix,$log);

echo <<< EOF
<script type="text/javascript">
	function autofocus(){
	
		document.forms['frmParents'].parents_name.focus();
	}
	function validateParents(){
		var name=document.forms['frmParents'].parents_name.value;

	if(confirm('Save Record?')){	
		if(name =="" ){		
			alert('Please make sure Parents name is filled in.');
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
$filterstring=$_GET['filterstring'];
$o->parents_id=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->parents_id=$_POST["parents_id"];

}
elseif(isset($_GET['action'])){
	$action=$_GET['action'];
	$o->parents_id=$_GET["parents_id"];
	

}
else
$action="";

$token=$_POST['token'];
$o->parents_contact=$_POST["parents_contact"];
$o->parents_name=$_POST["parents_name"];
$o->parents_contact2=$_POST["parents_contact2"];
$o->parents_email=$_POST["parents_email"];
$o->parents_email2=$_POST["parents_email2"];
$o->parents_name2=$_POST["parents_name2"];
$o->description=$_POST["description"];
$o->organization_id=$_POST["organization_id"];
$o->parents_occupation=$_POST['parents_occupation'];
$o->parents_occupation2=$_POST['parents_occupation2'];
$o->cur_name=$cur_name;
$o->cur_symbol=$cur_symbol;
$isactive=$_POST['isactive'];
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$o->isAdmin=$xoopsUser->isAdmin();

if ($isactive=="Y" or $isactive=="on")
	$o->isactive='Y';
else
	$o->isactive='N';

echo <<< EOF
<!--<div style="border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);"><big><big><big><span style="font-weight: bold;">Parent Master Record</span></big></big></big></div><br>-->
EOF;
if($filterstring=="")
$filterstring=$o->searchAToZ();
else
$o->searchAToZ();
 switch ($action){
	//When user submit new organization
  case "create" :
		// if the token is exist and not yet expired
	$log->showLog(4,"Accessing create record event, with parents name=$o->parents_name");

	if ($s->check(false,$token,"CREATE_PRN")){
		
		
		
	if($o->insertParents()){
		 $latest_id=$o->getLatestParentsID();
			 redirect_header("parents.php?action=edit&parents_id=$latest_id",$pausetime,"Your data is saved, the new id=$latest_id");
		}
	else {
		$log->showLog(1,"<b style='color:red'>Can't create '$o->parents_name', please verified your data.</b>");

		$token=$s->createToken($tokenlife,"CREATE_PRN");
		$o->orgctrl=$permission->selectionOrg($o->created,$o->organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showParentsTable(" WHERE p.parents_name LIKE '$filterstring%' AND p.isactive='Y' and parents_id>0 and p.organization_id = $defaultorganization_id ","ORDER BY parents_name"); 
		}
	}
	else{	// if the token is not valid or the token is expired, it back to previous form with previous inputed data
		$log->showLog(1,"<b style='color:red'>Can't create '$o->parents_name' due to token expired.</b>");

		$token=$s->createToken($tokenlife,"CREATE_PRN");
		$o->orgctrl=$permission->selectionOrg($o->created,$o->organization_id);
		$o->getInputForm("new",-1,$token);
		$o->showParentsTable(" WHERE p.parents_name LIKE '$filterstring%' AND p.isactive='Y' and parents_id>0 and p.organization_id = $defaultorganization_id ","ORDER BY parents_name"); 
	}
 
break;
	//when user request to edit particular organization
  case "edit" :
	if($o->fetchParents($o->parents_id)){
		//create a new token for editing a form
		$token=$s->createToken($tokenlife,"CREATE_PRN"); 
		$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id);
		$o->getInputForm("edit",$o->parents,$token);
		$o->showChildTable($o->parents_id);  
		$o->showParentsTable(" WHERE parents_name LIKE '$filterstring%' AND p.isactive='Y' and parents_id>0 and p.organization_id = $defaultorganization_id ","ORDER BY parents_name"); 
	}
	else	//if can't find particular organization from database, return error message
		redirect_header("parents.php",3,"<b style='color:red'>Some error on viewing your parents data, probably database corrupted.</b>");
  
break;
//when user press save for change existing organization data
  case "update" :
	if ($s->check(false,$token,"CREATE_PRN")){
		$o->updatedby=$xoopsUser->getVar('uid'); //get current uid
		if($o->updateParents()) //if data save successfully
			redirect_header("parents.php?action=edit&parents_id=$o->parents_id",$pausetime,"Your data is saved.");
		else
			redirect_header("parents.php?action=edit&parents_id=$o->parents_id",$pausetime,"<b style='color:red'>Warning! Can't save the data, please make sure all value is insert properly.</b>");
		}
	else{
		redirect_header("parents.php?action=edit&parents_id=$o->parents_id",$pausetime,"<b style='color:red'>Warning! Can't save the '$o->parents_name' due to token expired.</b>");
	}
  break;
  case "delete" :
	if ($s->check(false,$token,"CREATE_PRN")){
		if($o->deleteParents($o->parents_id))
			redirect_header("parents.php",$pausetime,"Data removed successfully.");
		else
			redirect_header("parents.php?action=edit&parents_id=$o->parents_id",$pausetime,"Warning! Can't delete data from database.");
	}
	else
		redirect_header("parents.php?action=edit&parents_id=$o->parents_id",$pausetime,"Warning! Can't delete data from database.");
	
  break;
  case "searchparents":
	$o->orgctrl=$permission->selectionOrg($o->createdby,$o->organization_id,'Y');

	$o->showSearchForm();
	if($_POST['isactive']=="Y")
		$o->isactive='Y';
	elseif($_POST['isactive']=="N")
		$o->isactive='N';
	else
		$o->isactive='-';
	$wherestr=generateWhereStr($o->isactive,$o->parents_name,$o->organization_id,
		$o->parents_name2,$o->description);
	$log->showLog(4,"Filter parents with wherestring $wherestr");
	$o->showParentsTable("$wherestr","ORDER BY parents_name");
  break;

  case "search":
	$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id,'Y');
	$o->showSearchForm();
  break;
  default :
	$token=$s->createToken($tokenlife,"CREATE_PRN");
	$o->orgctrl=$permission->selectionOrg($o->createdby,$defaultorganization_id);
	$o->getInputForm("new",0,$token);
	$o->showParentsTable(" WHERE p.parents_name LIKE '$filterstring%' AND p.isactive='Y' and parents_id>0 and p.organization_id = $defaultorganization_id ","ORDER BY parents_name");
  break;

}

function generateWhereStr($isactive,$parents_name,$organization_id,$parents_name2,$description){

$filterstring="";
$needand="";
if ($isactive!="-"){
$filterstring=$filterstring . " p.isactive = '$isactive' AND";
}

if ($organization_id>=0){
$filterstring=$filterstring . " p.organization_id = $organization_id AND";
}

if ($parents_name!="")
$filterstring=$filterstring . " p.parents_name LIKE '$parents_name' AND";

if ($parents_name2!="")
$filterstring=$filterstring . " p.parents_name2 LIKE '$parents_name2' AND";

if ($description!="")
$filterstring=$filterstring . " description LIKE '$description' AND";


if ($filterstring=="")
	return "WHERE p.parents_id>0";
else {
	$filterstring =substr_replace($filterstring,"",-3);  

	return "WHERE p.parents_id>0 AND $filterstring";
	}
}


echo '</td>';
require(XOOPS_ROOT_PATH.'/footer.php');

?>

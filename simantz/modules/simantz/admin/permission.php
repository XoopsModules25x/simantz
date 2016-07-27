<?php
include "system.php";
include "menu.php";
include_once XOOPS_ROOT_PATH.'class/Window.php';
include_once XOOPS_ROOT_PATH.'/class/Permission.php';


error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Permission();

$o->groupid=0;


if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->groupid=$_POST["groupid"];
	$o->lineallow=$_POST['lineallow'];
  	$o->linewindow_id=$_POST['linewindow_id'];
        $o->linepermissionsetting=$_POST['linepermissionsetting'];
        $o->linevaliduntil=$_POST['linevaliduntil'];
  	$o->lineallowwrite=$_POST['lineallowwrite'];
        $o->findmodule_id=$_POST['findmodule_id'];
        
}
elseif (isset($_GET['action'])){
	$action=$_GET['action'];
	$o->groupid=$_GET["groupid"];
        $o->findmodule_id=$_GET['findmodule_id'];
}
else
$action="";
if($o->findmodule_id=="")$o->findmodule_id=0;

$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$token=$_POST['token'];

echo <<< EOF

<script type="text/javascript">
	function selectall(value){
	var itemcount=document.forms['frmUpdatePermission'].linecount.value;
		for(var i = 0; i < itemcount; i++)
			document.forms['frmUpdatePermission'].elements["lineallow["+i+"]"].checked = value;
	}

	function selectallwriteperm(value){
	var itemcount=document.forms['frmUpdatePermission'].linecount.value;
		for(var i = 0; i < itemcount; i++)
			document.forms['frmUpdatePermission'].elements["lineallowwrite["+i+"]"].checked = value;
	}

</script>

EOF;
 switch ($action){
	//When user submit new organization
  case "search" :
	$o->showControlHeader($o->groupid,$o->findmodule_id);
	$o->showPermissionTable($o->groupid,$o->findmodule_id);
	//$o->generateMenu($o->createdby);
break;
  case "save":
	if($o->updatePermission())
	redirect_header("permission.php?action=search&groupid=$o->groupid&findmodule_id=$o->findmodule_id",$pausetime,"Your data is saved.");
	else
	redirect_header("permission.php?action=search&groupid=$o->groupid&findmodule_id=$o->findmodule_id",$pausetime,
		"<b style='color:red'>Can't update permission,</b> please contact developer.");
  
  break;
  default :
	$o->showControlHeader(0);
	 break;


};

require(XOOPS_ROOT_PATH.'/footer.php');

?>

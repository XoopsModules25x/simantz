<?php
include "system.php";
include_once '../../system/class/Log.php';
include_once '../class/Window.php';
include_once '../class/Permission.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

$log = new Log();
$o = new Permission();

$o->groupid=0;
if (isset($_POST['action'])){
	$action=$_POST['action'];
	$o->groupid=$_POST["groupid"];
	$o->lineallow=$_POST['lineallow'];
  	$o->linewindow_id=$_POST['linewindow_id'];

}
elseif (isset($_GET['action'])){
	$action=$_GET['action'];
	$o->groupid=$_GET["groupid"];
}
else
$action="";
$o->createdby=$xoopsUser->getVar('uid');
$o->updatedby=$xoopsUser->getVar('uid');
$token=$_POST['token'];

echo <<< EOF

<script type="text/javascript">
	function selectall(){
	var itemcount=document.forms['frmUpdatePermission'].linecount.value;
		for(var i = 0; i < itemcount; i++)
			document.forms['frmUpdatePermission'].elements["lineallow["+i+"]"].checked = true;
	}

	function removeall(){
	var itemcount=document.forms['frmUpdatePermission'].linecount.value;
		for(var i = 0; i < itemcount; i++)
			document.forms['frmUpdatePermission'].elements["lineallow["+i+"]"].checked = false;
	}

</script>

EOF;
 switch ($action){
	//When user submit new organization
  case "search" :
	$o->showControlHeader($o->groupid);
	$o->showPermissionTable($o->groupid);
	//$o->generateMenu($o->createdby);
break;
  case "save":
	if($o->updatePermission())
	redirect_header("permission.php?action=search&groupid=$o->groupid",$pausetime,"Your data is saved.");
	else
	redirect_header("permission.php?action=search&groupid=$o->groupid",$pausetime,
		"<b style='color:red'>Can't update permission,</b> please contact developer.");
  
  break;
  default :
	$o->showControlHeader(0);
	 break;


};

xoops_cp_footer();

?>

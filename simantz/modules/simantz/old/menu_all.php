<?php
include_once "system.php";
include_once "class/SelectCtrl.inc.php";
include_once '../themes/default/style.css';
global $menuname;
$ctrl= new SelectCtrl();
$parentwindows_id=0;
$orgctrl=$ctrl->selectionOrg($userid,$defaultorganization_id,$showNull='N');

	$curr_date = getDateSession($curr_date);
	//echo $curr_date=$defaultDateSession;
        $currenturl=curPageURL();
echo <<< EOF

<!-- Include files javascripts -->

<link rel="stylesheet" href="../simantz/include/stylemenu.css" type="text/css" />
<script type="text/javascript" src="../../modules/system/class/gui/oxygen/js/menu.js"></script>

<!--
  <div id="navbarCP" >

    <ul class="menu" id="menu">
    <li><a href='index.php' class='menulink'>Home</a></li>-->

    
EOF;
        $menulist = "<div id='navbarCP'><ul class='menu' id='menu'>
        <li>
        <a href='index.php' class='menulink'>Home</a>
        </li>";

$menulist .= $permission->showMenu($parentwindows_id,0,$userid,$module_id);
$menulist .= "</ul></div>";
$menulist = str_replace( array("\r\n", "\n","\r"), "", $menulist );

echo <<< EOF

<script type="text/javascript">
try {
document.getElementById('xo-globalnav').innerHTML = "$menulist";
var menu=new menu.dd("menu");
menu.init("menu","menuhover");
}catch (error) {
}

function setSessionDate(value,url){
if(url.indexOf("?") > -1)
location.href=url+'&setSessionDate=Y&defaultDateSession='+value;
else
location.href=url+'?setSessionDate=Y&defaultDateSession='+value;
}
</script>

	<div id='pagetitle'>$menuname</div><br>
	<div style='display:none' astyle='border: 1px solid rgb(153, 153, 255); color: rgb(0, 0, 153);'>
		<big><big><big>
		<span style='font-weight: bold;text-align:left'>$menuname </span>/
		<span style='text-align:right;'><strong> Organization $orgctrl</strong></span>
		</big></big></big>
        <input name='defaultDateSession' value='$curr_date' size='8' maxlength='10'
            onblur='setSessionDate(this.value,"$currenturl")'
                 title='Change value to preset prefered default date, this column will effect content of some chart too.'>
            <small title='Change value to preset prefered default date, this column will effect content of some chart too.'><U>* Default Date(YYYY-MM-DD)</U></small></div><br>

EOF;


?>


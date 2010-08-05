<?php
include_once "system.php";
include_once "../simantz/class/SelectCtrl.inc.php";
include_once '../themes/default/style.css';
global $menuname;
$ctrl= new SelectCtrl();

//print_r($_SERVER);
$deniedaccess=true;
$i=0;
foreach($allowbrowser as $ab){
    if(strpos($browser, $ab)>0)
        {$deniedaccess=false;
        break;

        }
    else
        continue;
$i++;        
}        
        
   if($deniedaccess && $i>0) //if user define will enforce checking
    redirect_header($url,300,"<b style='color:red'>You browser {$browser} is not supported, please contact the developer.</b>");
//if there is no module id submit from another include use simantz module as menu
if($parentwindows_id=="")
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
        $menulist = "<div style='height:30px'><div id='navbarCP'><ul class='menu' id='menu'>
        <li>
        <a href='index.php' class='menulink'>Homes</a>
        </li>";

$menulist .= $permission->showMenu($parentwindows_id,0,$userid,$module_id);
$menulist .= "</ul></div></div>";
$menulist = str_replace( array("\r\n", "\n","\r"), "", $menulist );
/*
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

	<div style='color: #4D2222;float:left;'>
		<span style='font-weight:bold;text-align:left;font-size:24px;'>$menuname </span>
        <input name='defaultDateSession' value='$curr_date' size='8' maxlength='10'
            onblur='setSessionDate(this.value,"$currenturl")'
                 title='Change value to preset prefered default date, this column will effect content of some chart too.'>
            <small title='Change value to preset prefered default date, this column will effect content of some chart too.'><U>* Default Date(YYYY-MM-DD)</U></small></div>
                
		<div style="float:right; v-align:bottom; padding-left:1em;color: #4D2222;">User: $uname</div><div style="float:right; text-align:right; v-align:bottom;color: #4D2222;">Organization $orgctrl</div>
	<br>

EOF;*/

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

	<div style='color: #4D2222; v-align:bottom; line-height:3em;'>
		<span style='font-weight:bold;text-align:left;font-size:24px;'>$menuname </span>
	<div style="float:right; v-align:bottom; padding-left:1em;color: #4D2222;line-height:3em;">User: $uname</div><div style="float:right; text-align:right; v-align:bottom;color: #4D2222;line-height:3em;">Organization $orgctrl</div>
       </div>
</br>
</br>
EOF;


?>


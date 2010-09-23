<?php
include_once "system.php";
include_once "../simantz/class/SelectCtrl.inc.php";
include_once '../themes/default/style.css';
global $menuname;
$ctrl= new SelectCtrl();

$browser=$_SERVER['HTTP_USER_AGENT'];
$deniedaccess=true;

$i=0;
foreach($allowbrowser as $ab){
        
$i++;        
    if(strpos($browser, $ab)>0)
        {
        $deniedaccess=false;

        break;

        }
    else
        continue;

}       
   if($deniedaccess!="" && $i>0) {//if user define will enforce checking
    redirect_header("$url",300,"<b style='color:red'>Your browser {$browser} is not supported, please click <a href='{$supportbrowserurl}' target='_blank'>here</a> to get supported browser.</b>");
   }
//if there is no module id submit from another include use simantz module as menu
if($parentwindows_id=="")
    $parentwindows_id=0;

	$curr_date = getDateSession($curr_date);
	//echo $curr_date=$defaultDateSession;
        $currenturl=curPageURL();
        $action=$_REQUEST['action'];
        if(strpos($currenturl,"?")>0)
                $newurl="'$currenturl&switchorg=Y&defaultorganization_id='+this.value+'&action=$action'";
        else
                $newurl="'$currenturl?action=$action&switchorg=Y&defaultorganization_id='+this.value";
$orgctrl=$ctrl->selectionOrg($userid,$defaultorganization_id,'N',"location.href=$newurl");

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
        <a href='index.php' class='menulink'>Home</a>
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
if($helpurl!="")
    $helpctrl="<a href='{$helpurl}' target='_blank'>Help</a>";
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

	<div style='color: #4D2222; v-align:top; line-height:3em;'>
	   <div style='float:left;font-weight:bold;text-align:left;font-size:24px;'>$menuname  </div>
           <div style='float:left;padding-left:1em;'> $helpctrl</div>
           <div style="float:right; v-align:top; padding-left:1em;color: #4D2222;">User: $uname</div>
           <div style="float:right; text-align:right; v-align:top;color: #4D2222;">Organization $orgctrl </div>
       </div><br/><br/><br/>
EOF;


?>


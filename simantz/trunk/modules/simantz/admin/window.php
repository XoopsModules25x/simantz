<?php

include_once "system.php";
include_once XOOPS_ROOT_PATH.'/modules/simantz/class/Window.inc.php';
$window = new Window();
$action=$_REQUEST['action'];
$window->updated=date("Y-m-d H:i:s",time());
$window->updatedby=$xoopsUser->getVar("uid");
switch($action){
case "ajaxfetch":
    if($window->fetchWindow($_REQUEST['window_id'] ) ){
        $window->returnWindowXML();
    }
    else
        echo "<xml><errortext>Cannot retrieve window_id:".$_REQUEST['window_id']."</errortext></xml>";

break;
case "ajaxgetmodulewindows":
    $window->mid=$_REQUEST['mid'];

    echo $window->showParentWindowsTree($window->mid);
    break;
case "ajaxdelete":
    $window->window_id=$_REQUEST['window_id'];
    if(!$window->deleteWindow($window->window_id))
            echo "Warning! Cannot delete this window due to unknown reason.";
    break;
case "ajaxsave":
    //print_r($_POST);
    $window->window_id=$_POST['window_id'];
    $window->window_name=$_POST['window_name'];
    if($_POST['isactive']=='on')
    $window->isactive=1;
    else
        $window->isactive=0;
    $window->filename=$_POST['filename'];
    $window->table_name=$_POST['table_name'];
    $window->windowsetting=$_POST['windowsetting'];
    $window->mid=$_POST['mid'];
    $window->seqno=$_POST['seqno'];
    $window->parentwindows_id=$_POST['parentwindows_id'];
    $window->description=$_POST['description'];
    $window->helpurl=str_replace("%26", "&", $_POST['helpurl']);
		$window->windowsetting=$_POST['windowsetting'];
		$window->jrxml=$_POST['jrxml'];

 	if (get_magic_quotes_gpc()) {
		$window->windowsetting=stripslashes($window->windowsetting);
		$window->jrxml=stripslashes($window->jrxml);
   	}
   
   
    if( $window->window_id>0)
            $window->updateWindow();
    else
            $window->insertWindow();
break;

case "ajaxselectwindows":
        $window->mid=$_GET['mid'];
        $window->window_id=$_GET['window_id'];
        if($window->window_id=="")$window->window_id=0;
        echo $window->getSelectWindows($window->window_id,$window->mid,"Y");
    break;
default:

if(file_exists("../simantz/")){
	include "menu.php";
	$window->modulectrl=$ctrl->getSelectModule($findmodule_id, "Y");
 	}
else{
    include "../class/SelectCtrl.inc.php";
    $ctrl  = new SelectCtrl();
	$window->modulectrl=$ctrl->getSelectModule($findmodule_id, "Y");
 }
    $xoTheme->addStylesheet("$url/modules/simantz/include/window.css");
        $xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
        $xoTheme->addScript("$url/modules/simantz/include/popup.js");
        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');



    if($_GET['findmodule_id']>=1)
        $findmodule_id=$_GET['findmodule_id'];
    else
        $findmodule_id=0;

    $window->showSearchForm();
     $windowlist=$window->showParentWindowsTree($findmodule_id);
     
    $formname=$window->getInputForm($findmodule_id);

    echo <<< EOF
<div id='blanket' style='display:none;'></div>
<div id='popUpDiv' style='display:none;verticle-align:center'>

     <div id='popupmessage' style='text-align:center'></div>
     <div id='progressimage' style='text-align:center'><img src='../images/ajax_indicator_01.gif'></div>
</div>


    <script>
        function reloadWindows(){
            var data="action=ajaxgetmodulewindows&mid="+$findmodule_id;
            $.ajax({
                 url: "window.php",type: "GET",data: data,cache: false,
                     success: function (xml) {

                         document.getElementById("treeModuleWindows").innerHTML=xml;
                         }
                    });

        }
        function addChildren(wid,mid){
                                 document.getElementById("window_id").value=0;
                                    document.getElementById("window_name").value="";
                                    document.getElementById("mid").value=mid;
                                    document.getElementById("seqno").value=10;
                                    document.getElementById("parentwindows_id").value=wid;
                                    document.getElementById("windowsetting").value="";
                                    document.getElementById("description").value="";
                                    document.getElementById("filename").value="";
                                    document.getElementById("table_name").value="";
                                    document.getElementById("helpurl").checked="";
                                    document.getElementById("isactive").checked=true;

        }

        function saverecord(){
                document.getElementById("popupmessage").innerHTML="Saving data...";
                popup('popUpDiv');
        var data = $("#frmwindow").serialize();
                var wid=document.getElementById("window_id").value;
          
                var isactive=0;
                if(document.getElementById("isactive").checked==true)
                isactive=1;
            var data=data;

            $.ajax({
                 url: "window.php",type: "POST",data: data,cache: false,
                     success: function (xml) {

                     document.getElementById("popupmessage").innerHTML="Saving data successfully, reload windows...";
                    showWindowsForm(wid);reloadWindows();
                    document.getElementById("popupmessage").innerHTML="Completed!";
                    popup('popUpDiv');
                }});




        }

        function refreshparentwindowslist(mid,window_id){

           // $("#parentwindows_id").html("");
            var data="action=ajaxselectwindows&mid="+mid+"&window_id="+window_id;
            $.ajax({
                 url: "window.php",type: "GET",data: data,cache: false,
                     success: function (xml) {

                      $("#parentwindows_id").html(xml);
                      document.getElementById('parentwindows_id').value=window_id;
                    }
            });

    }

        function showWindowsForm(wid){
            var data="action=ajaxfetch&window_id="+wid;
            $.ajax({
                 url: "window.php",type: "GET",data: data,cache: false,
                     success: function (xml) {
                             $(xml).find("Window").each(function()
                                {

                                    var currentwid = $(this).attr("id");
                                    var wname=$(this).find("window_name").text();
                                    var mid=$(this).find("mid").text();
                                    var seqno=$(this).find("seqno").text();
                                    var pwid=$(this).find("parentwindow_id").text();
                                    var wsetting=$(this).find("windowsetting").text();
                                    var desc=$(this).find("description").text();
                                    var fname=$(this).find("filename").text();
                                    var tbname=$(this).find("table_name").text();
                                    var helpurl=$(this).find("helpurl").text();
                                    var jrxml=$(this).find("jrxml").text();
                                    var isactive=$(this).find("isactive").text();
                                    document.getElementById("window_id").value=wid;
                                    document.getElementById("window_name").value=wname;
                                    document.getElementById("mid").value=mid;
                                    document.getElementById("seqno").value=seqno;
                                    document.getElementById("parentwindows_id").value=pwid;
                                    document.getElementById("windowsetting").value=wsetting;
                                    document.getElementById("helpurl").value=helpurl;
                                    document.getElementById("jrxml").value=jrxml;
                                    document.getElementById("description").value=desc;
                                    document.getElementById("filename").value=fname;
                                    document.getElementById("table_name").value=tbname;
                                    if(isactive==1)
                                        document.getElementById("isactive").checked=true;
                                    else
                                        document.getElementById("isactive").checked=false;
                      
                                });//close each
                              }//close success
                }); //close $.ajax
        }
        function deleterecord(){
          if(confirm('Delete this window?')){
           var wid=document.getElementById("window_id").value;
            var data="action=ajaxdelete&window_id="+wid;
            $.ajax({
                 url: "window.php",type: "POST",data: data,cache: false,
                     success: function (xml) {
                        alert("Record Delete.");
                        reloadWindows();
                    }});
          }
        }

        function addNew(){
                    document.getElementById("window_id").value=0;
                    document.getElementById("window_name").value="";
                    document.getElementById("mid").value=$findmodule_id;
                    document.getElementById("table_name").value="";
                    document.getElementById("seqno").value=10;
                   // document.getElementById("parentwindow_id").value=0;
                    document.getElementById("windowsetting").value="";
                    document.getElementById("description").value="";
                    document.getElementById("helpurl").value="";
                    document.getElementById("filename").value="";
                    document.getElementById("isactive").checked=true;

    }
     </script>
    <br/>
    <a href="index.php">Back to this module index</a>

    <table border=1px>
    <tr><TH colspan='2'>Add/Edit Windows</TH></tr>
    <tr>
    <td width="50%" style='vertical-align:top'><div id="treeModuleWindows">$windowlist</div></td>
    <td width="50%" style='vertical-align:top'><div id="formModuleWindows">$formname</div></td>
    </tr></table>




EOF;

if(file_exists("../simantz/"))
require(XOOPS_ROOT_PATH.'/footer.php');
else
xoops_cp_footer();

}

?>

<?php

include_once "system.php";
include_once '../class/Window.inc.php';
include "../class/nitobi.xml.php";
include "../class/SelectCtrl.inc.php";
if($windowsettingautosave){
$autosaveenabledwords="autosaveenabled=\"true\"";
$promptjavascript="";
}else{
$autosaveenabledwords="";
$promptjavascript="return confirm(\"Save record?\"))";
}
$window = new Window();

$ctrl  = new SelectCtrl();

$xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css");

$xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.toolkit.js");
$xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js");
$xoTheme->addScript("$url/modules/simantz/include/firefox3_6fix.js");

//$xoopsTpl->assign('xoops_pagetitle', $menuname);


echo <<< EOF
  <script language="javascript" type="text/javascript">
    jQuery(document).ready((function (){
        nitobi.loadComponent('DataboundGrid');
    }));

     function init(){}

     function search(){

        var grid = nitobi.getGrid("DataboundGrid");
        var searchmodule_id=document.getElementById("searchmodule_id").value;
        var searchfilename=document.getElementById("searchfilename").value;
        var searchwindow_name=document.getElementById("searchwindow_name").value;
        var searchisactive=document.getElementById("searchisactive").value;
        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        if(document.getElementById("searchisdeleted"))
        var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchmodule_id',searchmodule_id);
	grid.getDataSource().setGetHandlerParameter('searchfilename',searchfilename);
	grid.getDataSource().setGetHandlerParameter('searchwindow_name',searchwindow_name);
	grid.getDataSource().setGetHandlerParameter('searchisactive',searchisactive);
	grid.getDataSource().setGetHandlerParameter('searchisdeleted',searchisdeleted);

        //reload grid data
	grid.dataBind();
    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        //      var myAjaxRequest = new nitobi.ajax.HttpRequest();
        //      myAjaxRequest.handler = 'getMaxID.php?idname=window_id&tablename=sim_window';
        //      myAjaxRequest.async = false;
        //      myAjaxRequest.get();
        //      myResultKey = myAjaxRequest.httpObj.responseText;
        //      myResultKey.replace(/s/g, '');
        //      myResultKey = parseInt(myResultKey) + 1;
        //      return myResultKey.toString();
        return 0;
    }

    //input validation
    function validateSave(){
        jQuery('#msgbox').fadeTo('veryfast', 0, function() {});
        $promptjavascript;
    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();
        if (!errorMessage) {
           document.getElementById('msgbox').innerHTML="Record save successfully<br/>"+
           document.getElementById('msgbox').innerHTML;
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
           return true;
        }
    }

    //if save_data have error, trigger this function
    function showError(){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();
        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<b style=\"color:red\">"+errorMessage+"</b><br/>"+
             document.getElementById('msgbox').innerHTML;;
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
       jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }

    //if table load completely trigger this function
    function dataready(){
    }

    //if user click particular column trigger this function
    function clickrecord(eventArgs){
                    jQuery('#cellvalue').fadeTo('veryfast', 0, function() {
                    var grid = eventArgs.getSource();
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var value = grid.getCellObject(row,col).getValue();
                    document.getElementById('cellvalue').innerHTML="Value: "+value;
        
                });
                    jQuery('#cellvalue').fadeTo('fast', 1, function() {});
    }

</script>
EOF;
$window->modulectrl=$ctrl->getSelectModule(0, "Y","searchmodule_id","searchmodule_id");
$window->showSearchForm();

echo <<< EOF
<br/>
<a href="index.php">Back to this module index</a>

<table>
<tr><TH colspan='2'>Add/Edit Windows</TH></tr>
<tr><td width="90%">
<ntb:grid id="DataboundGrid"
     mode="livescrolling"
     rowinsertenabled="true"
     rowdeleteenabled="true"
     ondatareadyevent="dataready();"
     rowhighlightenabled="false"
     oncellclickevent="clickrecord(eventArgs)"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
    $autosaveenabledwords
     gethandler="../load_data.php?action=window&searchisactive=1"
     savehandler="../save_data.php?action=window"
     toolbarenabled="true"
     onbeforesaveevent="validateSave()"
     width="900px"
     height="500px"
     onaftersaveevent="savedone(eventArgs)"
     theme="$nitobigridthemes"
     rowsperpage="1">
   <ntb:columns>
       <ntb:textcolumn maxlength="2"   width="140" label="Module"  xdatafld="mid" >
           <ntb:lookupeditor  delay="1000" gethandler="../lookup.php?action=module" displayfields="name" valuefield="mid" >
            </ntb:lookupeditor>

        </ntb:textcolumn>
       <ntb:textcolumn  width="200" label="Parent"  xdatafld="parentwindows_id" >
             <ntb:lookupeditor  delay="1000" gethandler="../lookup.php?action=window" displayfields="window_name" valuefield="window_id" >
            </ntb:lookupeditor>
        </ntb:textcolumn>
       <ntb:textcolumn maxlength="50"  width="150" label="Window Name"   xdatafld="window_name" ></ntb:textcolumn>
       <ntb:textcolumn maxlength="50" width="110"  label="File Name"   xdatafld="filename"></ntb:textcolumn>
       <ntb:textcolumn      label="Active"   width="45"  xdatafld="isactive"   sortenabled="false">
             <ntb:checkboxeditor datasource="[{value:'1',display:'Yes'},{value:'0',display:'No'}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value">
            </ntb:checkboxeditor>
       </ntb:textcolumn>
       <ntb:numbercolumn   maxlength="4" label="Seq"  width="30" xdatafld="seqno" mask="###0"></ntb:numbercolumn>
       <ntb:textcolumn  width="100" label="Description"   xdatafld="description" ></ntb:textcolumn>
       <ntb:textcolumn width="100" label="Setting"   xdatafld="windowsetting"></ntb:textcolumn>

<ntb:textcolumn  label="Log"   xdatafld="info"    width="50"  sortenabled="false" >
            <ntb:linkeditor></ntb:linkeditor openwindow="true" >
       </ntb:textcolumn>
       <ntb:textcolumn      label="Deleted"   width="50"  xdatafld="isdeleted">
            <ntb:checkboxeditor datasource="[{valuedd:'1',displaydd:'Yes'},{valuedd:'0',displaydd:'No'}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="displaydd" valuefield="valuedd">
           </ntb:checkboxeditor>
       </ntb:textcolumn>
EOF;


 echo <<< EOF
 </ntb:grid>
  </td><td style="text-align: center;vertical-align:top">
<div id="cellvalue"></div>
<hr/>
Status:
<div id="msgbox"></div>


</td></tr></table>


EOF;
xoops_cp_footer();

?>

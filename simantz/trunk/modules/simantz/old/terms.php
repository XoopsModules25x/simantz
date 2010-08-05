<?php

//	include_once ('../../mainfile.php');
//	include_once (XOOPS_ROOT_PATH.'/header.php');
include "system.php";
include "menu.php";
include "class/nitobi.xml.php";
include "class/Terms.inc.php";
$terms = new Terms();
$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
$terms->showSearchForm();
if($havewriteperm==1)
   $permctrl=" rowinsertenabled=\"true\"      rowdeleteenabled=\"true\"      toolbarenabled=\"true\"      ";
else
   $permctrl=" rowinsertenabled=\"false\"   autosaveenabled=\"false\"   rowdeleteenabled=\"false\"      toolbarenabled=\"false\"      ";


echo <<< EOF
<link rel="stylesheet" href="include/nitobi/nitobi.grid/nitobi.grid.css" type="text/css" />
<script type="text/javascript" src="include/nitobi/nitobi.toolkit.js"></script>
<script type="text/javascript" src="include/nitobi/nitobi.grid/nitobi.grid.js"></script>
<script type="text/javascript" src="include/firefox3_6fix.js"></script>

  <script language="javascript" type="text/javascript">
    jQuery(document).ready((function (){nitobi.loadComponent('DataboundGrid');}));

     function init(){}

     function search(){

        var grid = nitobi.getGrid("DataboundGrid");
        var searchterms_name=document.getElementById("searchterms_name").value;

        var searchisactive=document.getElementById("searchisactive").value;

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        if(document.getElementById("searchisdeleted"))
        var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchterms_name',searchterms_name);
	grid.getDataSource().setGetHandlerParameter('searchisactive',searchisactive);
	grid.getDataSource().setGetHandlerParameter('searchisdeleted',searchisdeleted);

        //reload grid data
	grid.dataBind();
    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        //      var myAjaxRequest = new nitobi.ajax.HttpRequest();
        //      myAjaxRequest.handler = 'getMaxID.php?idname=country_id&tablename=sim_country';
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
        if(confirm("Save record?"))
            return true;
        else
            return false;
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

<table><tr><td width="10%">
<ntb:grid id="DataboundGrid"
     mode="livescrolling"

     $permctrl $windowsetting
     ondatareadyevent="dataready();"
     rowhighlightenabled="false"
     oncellclickevent="clickrecord(eventArgs)"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="load_data.php?action=terms&searchisactive=1"
     savehandler="save_data.php?action=terms"
     onbeforesaveevent="validateSave()"
     onaftersaveevent="savedone(eventArgs)"
     theme="$nitobigridthemes"
     rowsperpage="1">
   <ntb:columns>
       <ntb:textcolumn maxlength="30"  label="Terms Name"  xdatafld="terms_name" ></ntb:textcolumn>
       <ntb:textcolumn label="Description"  width="100" xdatafld="description" ></ntb:textcolumn>
       <ntb:textcolumn      label="Active"   width="45"  xdatafld="isactive"   sortenabled="false">
             <ntb:checkboxeditor datasource="[{value:'1',display:'Yes'},{value:'0',display:'No'}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value">
            </ntb:checkboxeditor>
       </ntb:textcolumn>
       <ntb:numbercolumn   maxlength="4" label="Default Level"  width="100" xdatafld="defaultlevel" mask="###0"></ntb:numbercolumn>
EOF;
//only admin user will see record info and isdeleted column
if($isadmin==1)
{
echo<<< EOF
<ntb:textcolumn  label="Log"   xdatafld="info"    width="50"  sortenabled="false" >
            <ntb:linkeditor></ntb:linkeditor openwindow="true" >
       </ntb:textcolumn>
       <ntb:textcolumn      label="Deleted"   width="50"  xdatafld="isdeleted">
            <ntb:checkboxeditor datasource="[{valuedd:'1',displaydd:'Yes'},{valuedd:'0',displaydd:'No'}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="displaydd" valuefield="valuedd">
           </ntb:checkboxeditor>
       </ntb:textcolumn>
EOF;
}

 echo <<< EOF
 </ntb:grid>
  </td><td>
<div id="cellvalue"></div>
<hr/>
Status:
<div id="msgbox" class="blockContent"></div>
</td></tr></table>
EOF;
require(XOOPS_ROOT_PATH.'/footer.php');

?>

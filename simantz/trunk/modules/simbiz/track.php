<?php
include "system.php";
include_once '../simbiz/class/Track.inc.php';

$o = new Trackclass();
$s = new XoopsSecurity();
$action=$_REQUEST['action'];
$isadmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');


switch($action){
case "search": //return xml table to grid
    $wherestring=" WHERE trackheader_id>0";
    $o->showTrackclass($wherestring);
    exit; //after return xml shall not run more code.
    break;
case "lookup": //return xml table to grid
     	include_once "../simantz/class/EBAGetHandler.php";
        $defaultorganization_id=$_SESSION['defaultorganization_id'];
        $lookupdelay=1000;
        $pagesize=&$_GET["pagesize"];
        $ordinalStart=&$_GET["startrecordindex"];
        $sortcolumn=&$_GET["sortcolumn"];
        $sortdirection=&$_GET["sortdirection"];

        $getHandler = new EBAGetHandler();
        $getHandler->ProcessRecords();
        $wherestring=" WHERE trackheader_id>0";
        $o->showLookupTrackclass($wherestring);
    exit; //after return xml shall not run more code.
    break;
case "save": //process submited xml data from grid
     $o->saveTrackclass();
    break;

case "searchtrack": //return xml table to grid
    $wherestring=" WHERE track_id>0";
    $o->showTrack($wherestring);
    exit; //after return xml shall not run more code.
    break;
case "savetrack": //process submited xml data from grid
     $o->saveTrack();
    break;

default:
include "menu.php";
$xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
$xoTheme->addScript("$url/modules/simantz/include/popup.js");
$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
$xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.toolkit.js");
$xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css");
$xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js");
$xoTheme->addScript("$url/modules/simantz/include/firefox3_6fix.js");

$o->showSearchForm(); //produce search form, comment here to hide search form
if($isadmin==1){
    $grIdColumn=6; //define primary key column index, it will set as readonly afterwards (count from 0)
    //    $deleteddefaultvalue_js="myGrid.getCellObject(rowNo,6).setValue(0);"; //if admin login got deleted column, during admin insert new record shall set it default =0 (not deleted)
    $grIdColumnTrack=5;
    $changewidth="width='155'";

}
else{
    $grIdColumn=5;//define primary key column index for normal user
    $grIdColumnTrack=4;
    $deleteddefaultvalue_js="";
        $changewidth="width='180'";
}

if($havewriteperm==1){ //user with write permission can edit grid, have button

   $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $permctrltrack=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $savectrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button" style="display:none">
     <input name="btnSave" onclick="save()" value="Save" type="button">';
   $savetrackctrl='<input name="btnAddtrack" id="btnAddtrack"  onclick="addlinetrack()" value="Add New Track" type="button" style="display:none">
     <input name="btnSavetrack" id="btnSavetrack" onclick="savetrack()" value="Save" type="button" style="display:none">';
    // <input name="btnDelete" onclick="onclickdeletebutton()" value="Delete" type="button">
    $alloweditgrid= "col!=$grIdColumn";
}
else{ //user dun have write permission, cannot save grid
    $savectrl="";
    $savetrackctrl="";
   $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $permctrltrack=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $alloweditgrid= "false";
}
 echo <<< EOF

  <script language="javascript" type="text/javascript">

    jQuery(document).ready((function ()
        {nitobi.loadComponent('DataboundGrid');
         nitobi.loadComponent('DetailGrid');}
    ));

    function init(){}

     function search(){
        var grid = nitobi.getGrid("DataboundGrid");
        var searchtrackheader_code=document.getElementById("searchtrackheader_code").value;
        var searchtrackheader_name=document.getElementById("searchtrackheader_name").value;
        var searchisactive=document.getElementById("searchisactive").value;

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        if(document.getElementById("searchisdeleted"))
        var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchtrackheader_code',searchtrackheader_code);
	grid.getDataSource().setGetHandlerParameter('searchtrackheader_name',searchtrackheader_name);
	grid.getDataSource().setGetHandlerParameter('searchisactive',searchisactive);
	grid.getDataSource().setGetHandlerParameter('searchisdeleted',searchisdeleted);

        //reload grid data
	grid.dataBind();

    }

     function searchtrack(){
        var grid = nitobi.getGrid("DetailGrid");
        var trackheader_id=document.getElementById("trackheader_id").value;

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('trackheader_id',trackheader_id);

        //reload grid data
	grid.dataBind();

    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        return 0;
    }

    //after grid html render properly, set focus on it. It is important when use choose particular cell but
    // immediately press search again. From screen we won't detect cell is selected infact from javascript
    // detect selected
   function dataready(){

       var  g = nitobi.getGrid('DataboundGrid');
        g.move(0,0);//need to trigger relative position 0,0 in for next code able to highlight at screen
        var selRow = g.getSelectedRow();

    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();

        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="Record save successfully";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                         search();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	search();

                popup('popUpDiv');

        	return false;
        	}
    }

    function savedonetrack(eventArgs){
        var grid= nitobi.getGrid('DetailGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();

        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="Record save successfully";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                         searchtrack();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	searchtrack();

                popup('popUpDiv');

        	return false;
        	}
    }

    //if save_data have error, trigger this function
    function showError(){

        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();

       if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<b style=\"color:red\">"+errorMessage+"</b><br/>";
            // document.getElementById('popupmessage').innerHTML="Please Wait.....";
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
          // document.getElementById('popupmessage').innerHTML="Please Wait.....";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }
    //if save_data have error, trigger this function
    function showErrortrack(){

        var grid= nitobi.getGrid('DetailGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();

       if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<b style=\"color:red\">"+errorMessage+"</b><br/>";
            // document.getElementById('popupmessage').innerHTML="Please Wait.....";
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
          // document.getElementById('popupmessage').innerHTML="Please Wait.....";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }

    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){

    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('DataboundGrid');
        g.insertRow();
    }
    function addlinetrack(){
    var g= nitobi.getGrid('DetailGrid');
        g.insertRow();
    }


    //trigger save activity from javascript
   function save()
     {
      if(validateEmpty()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DataboundGrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
          //popup('popUpDiv');
     	  var g= nitobi.getGrid('DataboundGrid');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
	    search();
    	   }

	 }
      }
      else{
      document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Trackclass code and trackheader name.</b><br/>";

      }
    }

   function savetrack()
     {
      if(validateEmptytrack()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DetailGrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
          //popup('popUpDiv');
     	  var g= nitobi.getGrid('DetailGrid');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
	    searchtrack();
    	   }

	 }
      }
      else{
      document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Track name.</b><br/>";

      }
    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

   function onclickdeletebuttontrack(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('DetailGrid');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

    function checkAllowEdit(eventArgs){
	var g= nitobi.getGrid('DataboundGrid');
        col=eventArgs.getCell().getColumn();
       if($alloweditgrid) //if user have permission to edit the cell, control primary key column read only at here too
        return true;
        else
        return false;
        }

//after insert a new line will automatically fill in some value here
  function setDefaultValue(eventArgs)
   {
   var myGrid = eventArgs.getSource();
   var r = eventArgs.getRow();
   var rowNo = r.Row;
   myGrid.getCellObject(rowNo,4).setValue(10);
        $deleteddefaultvalue_js
   myGrid.selectCellByCoords(rowNo, 0);
}

  function setDefaultValuetrack(eventArgs)
   {
   var myGrid = eventArgs.getSource();
   var r = eventArgs.getRow();
   var rowNo = r.Row;
   trackheader_id = document.getElementById("trackheader_id").value;
   myGrid.getCellObject(rowNo,4).setValue(trackheader_id);
   myGrid.getCellObject(rowNo,2).setValue(10);
   myGrid.selectCellByCoords(rowNo, 0);
}

	function beforeDelete(){
		if(confirm('Delete this record? Data will save into database immediately.')){
			document.getElementById("afterconfirm").value=1;
      //popup('popUpDiv');
			return true;
		}
			else{
			document.getElementById("afterconfirm").value=0;
			return false;
			}
		}
    function viewlog(){
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
      window.open(cellObj,"");
    }
    function viewlogtrack(){
   	var g= nitobi.getGrid('DetailGrid');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
      window.open(cellObj,"");
    }
    function validateEmpty(){

        var grid= nitobi.getGrid('DataboundGrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var name ="";
        var no ="";

        for( var i = 0; i < total_row; i++ ) {
        var namecell = grid.getCellObject( i, 0);//1st para : row , 2nd para : column seq
        var nocell = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq

           name = namecell.getValue();
           no = nocell.getValue();
           if(name=="" || no=="")
           {
            isallow = false;
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }
    function validateEmptytrack(){

        var grid= nitobi.getGrid('DetailGrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var name ="";

        for( var i = 0; i < total_row; i++ ) {
        var namecell = grid.getCellObject( i, 0);//1st para : row , 2nd para : column seq

           name = namecell.getValue();
           if(name=="")
           {
            isallow = false;
           }
        }
        if(isallow)
          return true;
        else
          return false;
    }
 function ChooseTrack(eventArgs)
	{
		var myRow = eventArgs.cell.getRow();
		var myMasterGrid = nitobi.getComponent('DataboundGrid');
		var trackheader_id = myMasterGrid.getCellObject(myRow,$grIdColumn).getValue();

                if(trackheader_id!="" || trackheader_id!="0"){
                document.getElementById("btnAddtrack").style.display="inline";
                document.getElementById("btnSavetrack").style.display="inline";
                }
                else{
                document.getElementById("btnAddtrack").style.display="none";
                document.getElementById("btnSavetrack").style.display="none";
                }
                if(document.getElementById("trackheader_id").value!=trackheader_id){
                document.getElementById("trackheader_id").value=trackheader_id;
		var myDetailGrid = nitobi.getComponent('DetailGrid');
		myDetailGrid.getDataSource().setGetHandlerParameter('trackheader_id', trackheader_id);

		myDetailGrid.dataBind();
                }
                if(trackheader_id!=""){
               // document.getElementById("editabled").value=1;
                }

	}
</script>
<br/>

<div align="center">
<table style="width:700px;">

<tr><td align="left" style="height:27px;">$savectrl</td>
   <td align="left" style="height:27px;">$savetrackctrl</td></tr>
<input type="hidden" name="trackheader_id" id="trackheader_id" value="">
<tr><td align="left">
<div>
<ntb:grid id="DataboundGrid"
     mode="nonpaging"
     toolbarenabled='false'
     $permctrl
     onhtmlreadyevent="dataready()"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="track.php?action=search"
     savehandler="track.php?action=save"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     onafterrowinsertevent="setDefaultValue(eventArgs)"
     rowhighlightenabled="true"
     width="550"
     height="250"
     oncellclickevent="ChooseTrack(eventArgs)"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes">
 <ntb:columns>
   <ntb:textcolumn  width="80" label="Code" xdatafld="trackheader_code"  classname="{\$rh}" ></ntb:textcolumn>
   <ntb:textcolumn width="150" label="Name" xdatafld="trackheader_name"  classname="{\$rh}"></ntb:textcolumn>
   <ntb:textcolumn  visible="false" $changewidth label="Citizenship" xdatafld="trackheader_description" classname="{\$rh}" ></ntb:textcolumn>
   <ntb:textcolumn visible="false" label="Active" width="45" xdatafld="isactive" sortenabled="true"  classname="{\$rh}" align="center">
         <ntb:checkboxeditor datasource="[{value:'1',display:''},{value:'0',display:''}]"
          checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value"></ntb:checkboxeditor>
        </ntb:textcolumn>
   <ntb:numbercolumn visible="false" maxlength="5" label="Seq No"  width="50" xdatafld="seqno" mask="###0"  classname="{\$rh}"></ntb:numbercolumn>
EOF;
//only admin user will see record info and isdeleted column
if($isadmin==1)
{
echo<<< EOF
<ntb:textcolumn  label="Log"   xdatafld="info"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlog()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
EOF;
}
 echo <<< EOF
      <ntb:numbercolumn  visible="false" label="ID"  width="0" xdatafld="trackheader_id" mask="###0" sortenabled="false"></ntb:numbercolumn>
      <ntb:textcolumn  visible="false" label="Del"   xdatafld=""    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebutton()">
            <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>
</ntb:columns>
</ntb:grid>
    </div>
</td>

 <td align="left">
        <ntb:grid id="DetailGrid"
             mode="standard"
             toolbarenabled='false'
             $permctrltrack
             ondatareadyevent="dataready();"
             onhandlererrorevent="showErrortrack()"
             keygenerator="GetNewRecordID();"
             singleclickeditenabled="true"
             onafterrowinsertevent="setDefaultValuetrack(eventArgs)"
             gethandler="track.php?action=searchtrack"
             savehandler="track.php?action=savetrack"
             rowhighlightenabled="true"
             width="350"
             height="250"
             onaftersaveevent="savedonetrack(eventArgs)"
             onbeforerowdeleteevent="beforeDelete()"
             onafterrowdeleteevent="savetrack()"
             autosaveenabled="false"
             theme="$nitobigridthemes"
             >

<ntb:columns>
   <ntb:textcolumn width="180" label="Track Name" xdatafld="track_name"  classname="{\$rh}"></ntb:textcolumn>
  
   <ntb:textcolumn label="Active" width="45" xdatafld="isactive" sortenabled="true"  classname="{\$rh}" align="center">
         <ntb:checkboxeditor datasource="[{value:'1',display:''},{value:'0',display:''}]"
          checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value"></ntb:checkboxeditor>
        </ntb:textcolumn>
   <ntb:numbercolumn maxlength="5" label="Seq No"  width="50" xdatafld="seqno" mask="###0"  classname="{\$rh}"></ntb:numbercolumn>
EOF;
//only admin user will see record info and isdeleted column
if($isadmin==1)
{
echo<<< EOF
<ntb:textcolumn  label="Log"   xdatafld="info"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlogtrack()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
EOF;
}
 echo <<< EOF
      <ntb:numbercolumn   label="trackheaderID"  width="0" xdatafld="trackheader_id" mask="###0" sortenabled="false" editable="false"></ntb:numbercolumn>
      <ntb:numbercolumn   label="ID"  width="0" xdatafld="track_id" mask="###0" sortenabled="false" editable="false"></ntb:numbercolumn>
      <ntb:textcolumn  label="Del"   xdatafld=""    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebuttontrack()">
            <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>
</ntb:columns>
         </ntb:grid>

        </td>

</tr>
<tr><td align="left">
  <input id='afterconfirm' value='0' type='hidden'>

<div id="msgbox" class="blockContent"></div>
</td></tr></table></div>
EOF;

require(XOOPS_ROOT_PATH.'/footer.php');

    break;
}


?>

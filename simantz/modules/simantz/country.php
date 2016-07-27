<?php
include "system.php";
include_once '../simantz/class/Country.inc.php';

$o = new Country();
$s = new XoopsSecurity();
$action=$_REQUEST['action'];
$isadmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');


switch($action){
case "search": //return xml table to grid
    $wherestring=" WHERE country_id>0";
    $o->showCountry($wherestring);
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
        $wherestring=" WHERE country_id>0";
        $o->showLookupCountry($wherestring);
    exit; //after return xml shall not run more code.
    break;
case "save": //process submited xml data from grid
     $o->saveCountry();
    break;

case "searchregion": //return xml table to grid
    $wherestring=" WHERE region_id>0";
    $o->showRegion($wherestring);
    exit; //after return xml shall not run more code.
    break;
case "saveregion": //process submited xml data from grid
     $o->saveRegion();
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
    $grIdColumn=7; //define primary key column index, it will set as readonly afterwards (count from 0)
    //    $deleteddefaultvalue_js="myGrid.getCellObject(rowNo,6).setValue(0);"; //if admin login got deleted column, during admin insert new record shall set it default =0 (not deleted)
    $grIdColumnRegion=5;
    $changewidth="width='155'";

}
else{
    $grIdColumn=6;//define primary key column index for normal user
    $grIdColumnRegion=4;
    $deleteddefaultvalue_js="";
        $changewidth="width='180'";
}

if($havewriteperm==1){ //user with write permission can edit grid, have button

   $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $permctrlregion=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $savectrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
     <input name="btnSave" onclick="save()" value="Save" type="button">';
   $saveregionctrl='<input name="btnAddregion" id="btnAddregion"  onclick="addlineregion()" value="Add New State" type="button" style="display:none">
     <input name="btnSaveregion" id="btnSaveregion" onclick="saveregion()" value="Save" type="button" style="display:none">';
    // <input name="btnDelete" onclick="onclickdeletebutton()" value="Delete" type="button">
    $alloweditgrid= "col!=$grIdColumn";
}
else{ //user dun have write permission, cannot save grid
    $savectrl="";
    $saveregionctrl="";
   $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $permctrlregion=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
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
        var searchcountry_code=document.getElementById("searchcountry_code").value;
        var searchcountry_name=document.getElementById("searchcountry_name").value;
        var searchisactive=document.getElementById("searchisactive").value;

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        if(document.getElementById("searchisdeleted"))
        var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchcountry_code',searchcountry_code);
	grid.getDataSource().setGetHandlerParameter('searchcountry_name',searchcountry_name);
	grid.getDataSource().setGetHandlerParameter('searchisactive',searchisactive);
	grid.getDataSource().setGetHandlerParameter('searchisdeleted',searchisdeleted);

        //reload grid data
	grid.dataBind();

    }

     function searchregion(){
        var grid = nitobi.getGrid("DetailGrid");
        var country_id=document.getElementById("country_id").value;

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('country_id',country_id);

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
                         var gridDetail = nitobi.getGrid("DetailGrid");
                         gridDetail.dataBind();
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

    function savedoneregion(eventArgs){
        var grid= nitobi.getGrid('DetailGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();

        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="Record save successfully";
                         //document.getElementById('popupmessage').innerHTML="Please Wait.....";
                         searchregion();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	searchregion();

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
    function showErrorregion(){

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
    function addlineregion(){
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
    }

   function saveregion()
     {
      if(validateEmptyregion()){
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
	    searchregion();
    	   }

	 }
      }
      else{
      document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Region name.</b><br/>";

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
        else{
         g.deleteCurrentRow();
         document.getElementById("btnAddregion").style.display="none";
         document.getElementById("btnSaveregion").style.display="none";
        }
    }

   function onclickdeletebuttonregion(){ //when press delete button will triger this function and ask for confirmation
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
   myGrid.getCellObject(rowNo,5).setValue(10);
        $deleteddefaultvalue_js
   myGrid.selectCellByCoords(rowNo, 0);
}

  function setDefaultValueregion(eventArgs)
   {
   var myGrid = eventArgs.getSource();
   var r = eventArgs.getRow();
   var rowNo = r.Row;
   getcountry_id = document.getElementById("country_id").value;
   myGrid.getCellObject(rowNo,4).setValue(getcountry_id);
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
    function viewlogregion(){
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
        var citi ="";

        for( var i = 0; i < total_row; i++ ) {
        var namecell = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq
        var nocell = grid.getCellObject( i, 0);//1st para : row , 2nd para : column seq
        var citicell = grid.getCellObject( i, 2);//1st para : row , 2nd para : column seq

           name = namecell.getValue();
           no = nocell.getValue();
           citi = citicell.getValue();
           if(citi=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Citizenship.</b><br/>";
           }
           if(name=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Country name.</b><br/>";
           }
           if( no=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Country code.</b><br/>";
           }
   
        }

        if(isallow)
          return true;
        else
          return false;
    }
    function validateEmptyregion(){

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
 function ChooseRegion(eventArgs)
	{
		var myRow = eventArgs.cell.getRow();
		var myMasterGrid = nitobi.getComponent('DataboundGrid');
		var country_id = myMasterGrid.getCellObject(myRow,$grIdColumn).getValue();

                if(country_id!="" || country_id!="0"){
                document.getElementById("btnAddregion").style.display="inline";
                document.getElementById("btnSaveregion").style.display="inline";
                }
                else{
                document.getElementById("btnAddregion").style.display="none";
                document.getElementById("btnSaveregion").style.display="none";
                }
                if(document.getElementById("country_id").value!=country_id){
                document.getElementById("country_id").value=country_id;
		var myDetailGrid = nitobi.getComponent('DetailGrid');
		myDetailGrid.getDataSource().setGetHandlerParameter('country_id', country_id);

		myDetailGrid.dataBind();
                }
                if(country_id!=""){
               // document.getElementById("editabled").value=1;
                }

	}
</script>
<br/>

<div align="center">
<table style="width:700px;">

<tr><td align="left" style="height:27px;">$savectrl</td>
   <td align="left" style="height:27px;">$saveregionctrl</td></tr>
<input type="hidden" name="country_id" id="country_id" value="">
<tr><td align="left">
<div>
<ntb:grid id="DataboundGrid"
     mode="nonpaging"
     toolbarenabled='false'
     $permctrl
     singleclickeditenabled="false"
     onhtmlreadyevent="dataready()"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="country.php?action=search"
     savehandler="country.php?action=save"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     onafterrowinsertevent="setDefaultValue(eventArgs)"
     rowhighlightenabled="true"
     width="590"
     height="250"
     oncellclickevent="ChooseRegion(eventArgs)"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes">
 <ntb:columns>
   <ntb:textcolumn  width="75" label="Country Code" xdatafld="country_code"  classname="{\$rh}" ></ntb:textcolumn>
   <ntb:textcolumn width="145" label="Country Name" xdatafld="country_name"  classname="{\$rh}"></ntb:textcolumn>
   <ntb:textcolumn  $changewidth label="Citizenship" xdatafld="citizenship" classname="{\$rh}" ></ntb:textcolumn>
   <ntb:textcolumn  width="49" label="Tel Code" xdatafld="telcode" classname="{\$rh}" ></ntb:textcolumn>
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
<ntb:textcolumn  label="Log"   xdatafld="info"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlog()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
EOF;
}
 echo <<< EOF
      <ntb:numbercolumn   label="ID"  visible="false" width="0" xdatafld="country_id" mask="###0" sortenabled="false"></ntb:numbercolumn>
      <ntb:textcolumn  label="Del"   xdatafld=""    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebutton()">
            <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>
</ntb:columns>
</ntb:grid>
    </div>
</td>

 <td align="left">
        <ntb:grid id="DetailGrid"
             mode="standard"
             toolbarenabled='false'
             $permctrlregion
             ondatareadyevent="dataready();"
             onhandlererrorevent="showErrorregion()"
             keygenerator="GetNewRecordID();"
             singleclickeditenabled="true"
             onafterrowinsertevent="setDefaultValueregion(eventArgs)"
             gethandler="country.php?action=searchregion"
             savehandler="country.php?action=saveregion"
             rowhighlightenabled="true"
             width="350"
             height="250"
             onaftersaveevent="savedoneregion(eventArgs)"
             onbeforerowdeleteevent="beforeDelete()"
             onafterrowdeleteevent="saveregion()"
             autosaveenabled="false"
             theme="$nitobigridthemes"
             >

<ntb:columns>
   <ntb:textcolumn width="180" label="State Name" xdatafld="region_name"  classname="{\$rh}"></ntb:textcolumn>
  
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
<ntb:textcolumn  label="Log"   xdatafld="info"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlogregion()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
EOF;
}
 echo <<< EOF
      <ntb:numbercolumn   label="countryID" visible="false" width="0" xdatafld="country_id" mask="###0" sortenabled="false" editable="false"></ntb:numbercolumn>
      <ntb:numbercolumn   label="ID"   visible="false" width="0" xdatafld="region_id" mask="###0" sortenabled="false" editable="false"></ntb:numbercolumn>
      <ntb:textcolumn  label="Del"   xdatafld=""    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebuttonregion()">
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

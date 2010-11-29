<?php
include "system.php";
include_once '../simantz/class/User.inc.php';

$o = new User();
$s = new XoopsSecurity();
$action=$_REQUEST['action'];
$isadmin=$xoopsUser->isAdmin();
$uid = $xoopsUser->getVar('uid');


switch($action){
case "search": //return xml table to grid
    $wherestring=" WHERE uid>0";
    $o->showUser($wherestring);
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
        $wherestring=" WHERE uid>0";
        $o->showLookupUser($wherestring);
    exit; //after return xml shall not run more code.
    break;
case "save": //process submited xml data from grid

     $o->saveUser();

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
     //   $deleteddefaultvalue_js="myGrid.getCellObject(rowNo,9).setValue(0);"; //if admin login got deleted column, during admin insert new record shall set it default =0 (not deleted)
    $changewidth="width='265'";

}
else{
    $grIdColumn=5;//define primary key column index for normal user
    $deleteddefaultvalue_js="";
        $changewidth="width='340'";
}

if($havewriteperm==1){ //user with write permission can edit grid, have button

   $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $hidewidth="width='25'";
   $savectrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
     <input name="btnSave" onclick="save()" value="Save" type="button">';
    // <input name="btnDelete" onclick="onclickdeletebutton()" value="Delete" type="button">
    $alloweditgrid= "col!=$grIdColumn";
}
else{ //user dun have write permission, cannot save grid
    $savectrl="";
   $hidewidth="width='0'";
   $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $alloweditgrid= "false";
}
 echo <<< EOF

  <script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){nitobi.loadComponent('DataboundGrid');}));

    function init(){}

     function search(){
        var grid = nitobi.getGrid("DataboundGrid");
        var searchname=document.getElementById("searchname").value;
        var searchuname=document.getElementById("searchuname").value;
        var searchuser_isactive=document.getElementById("searchuser_isactive").value;

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        if(document.getElementById("searchisdeleted"))
        var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchname',searchname);
	grid.getDataSource().setGetHandlerParameter('searchuname',searchuname);
	grid.getDataSource().setGetHandlerParameter('searchuser_isactive',searchuser_isactive);
	grid.getDataSource().setGetHandlerParameter('searchisdeleted',searchisdeleted);

        //reload grid data
	grid.dataBind();

    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        //      var myAjaxRequest = new nitobi.ajax.HttpRequest();
        //      myAjaxRequest.handler = 'getMaxID.php?idname=uid&tablename=sim_simedu_period';
        //      myAjaxRequest.async = false;
        //      myAjaxRequest.get();
        //      myResultKey = myAjaxRequest.httpObj.responseText;
        //      myResultKey.replace(/s/g, '');
        //      myResultKey = parseInt(myResultKey) + 1;
        //      return myResultKey.toString();
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


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var  myGrid = nitobi.getGrid('DataboundGrid');
                    var myCell = myGrid.getCellObject(row, col);
                   // myCell.edit();
    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('DataboundGrid');
        g.insertRow();
    }

    //trigger save activity from javascript
   function save()
     {
      if(validateEmpty()){
        if(validateMonth()){
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
                  // else //cancel request
                    //search();
                }
         }
        else{
        document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Month error, please enter value between 1~12.</b><br/>";
         }
      }
      else{
      document.getElementById('msgbox').innerHTML="<b style=\"color:red\">User name, month and year cannot be null</b><br/>";

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

   function onclicklogbutton(){ //when press delete button will triger this function and ask for confirmation
       window.open('','y');
//   	var g= nitobi.getGrid('DataboundGrid');
//        var selRow = g.getSelectedRow();
//	var cellObj = g.getCellValue(selRow, 8);
//
//        window.open('','y');

       //alert(cellObj);
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

    function validateEmpty(){

        var grid= nitobi.getGrid('DataboundGrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var name ="";
        var month ="";
        var year ="";

        for( var i = 0; i < total_row; i++ ) {
        var namecell = grid.getCellObject( i, 0);//1st para : row , 2nd para : column seq
        var monthcell = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq
        var yearcell = grid.getCellObject( i, 2);//1st para : row , 2nd para : column seq

           name = namecell.getValue();
           month = monthcell.getValue();
           year= yearcell.getValue();
           if(name=="" || month=="" || year=="")
           {
            isallow = false;
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }
    function validateMonth(){

        var grid= nitobi.getGrid('DataboundGrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var month ="";

        for( var i = 0; i < total_row; i++ ) {
        var monthcell = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq
           month = monthcell.getValue();
           if(month>12)
           {
            isallow = false;
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }
</script>
<br/>

<div align="center">
<table style="width:700px;">

<tr><td align="left" style="height:27px;">$savectrl</td></tr>

<tr><td align="center">
<div>
<ntb:grid id="DataboundGrid"
     mode="nonpaging"
     toolbarenabled='false'
     $permctrl
     singleclickeditenabled="true"
     onhtmlreadyevent="dataready()"

     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="period.php?action=search"
     savehandler="period.php?action=save"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     onafterrowinsertevent="setDefaultValue(eventArgs)"
     rowhighlightenabled="true"
     width="943"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes">
 <ntb:columns>
   <ntb:textcolumn width="210" label="User Name" xdatafld="uname"  classname="{\$rh}"></ntb:textcolumn>
   <ntb:numbercolumn  width="85" label="Full Name" xdatafld="name"  classname="{\$rh}" maxLength="4" mask="0000"></ntb:numbercolumn>
   <ntb:numbercolumn width="85" label="Email" xdatafld="email" classname="{\$rh}" maxLength="2" mask="###0" ></ntb:numbercolumn>
   <ntb:textcolumn label="Active" width="45" xdatafld="user_isactive" sortenabled="true"  classname="{\$rh}">
         <ntb:checkboxeditor datasource="[{value:'1',display:''},{value:'0',display:''}]"
          checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value"></ntb:checkboxeditor>
        </ntb:textcolumn>
   <ntb:numbercolumn maxlength="5" label="Seq No"  width="50" xdatafld="pass" mask="###0"  classname="{\$rh}"></ntb:numbercolumn>
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
      <ntb:numbercolumn   label="ID"  width="0" xdatafld="uid" mask="###0" sortenabled="false"></ntb:numbercolumn>
      <ntb:textcolumn  label="Del"   xdatafld="" $hidewidth  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebutton()">
            <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>
</ntb:columns>
</ntb:grid>
    </div>
</td></tr>
<tr><td align="left">
  <input id='afterconfirm' value='0' type='hidden'>
    Status:
<div id="msgbox" class="blockContent"></div>
</td></tr></table></div>
EOF;

require(XOOPS_ROOT_PATH.'/footer.php');

    break;
}


?>

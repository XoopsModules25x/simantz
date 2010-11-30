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

if($havewriteperm==1){ //user with write permission can edit grid, have button

   $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $hidewidth="width='25'";
   $savectrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
     <input name="btnSave" onclick="save()" value="Save" type="button">';
    // <input name="btnDelete" onclick="onclickdeletebutton()" value="Delete" type="button">
    $alloweditgrid= "true";
}
else{ //user dun have write permission, cannot save grid
    $savectrl="";
   $hidewidth="width='0'";
   $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $alloweditgrid= "false";
}
 echo <<< EOF

  <script language="javascript" type="text/javascript">
    var gc = new Array();
    jQuery(document).ready((function (){
        nitobi.loadComponent('DataboundGrid');
        getgridcol();
    }));
    

    function getgridcol(){
        var grid = nitobi.getGrid("DataboundGrid");
        var totalcol = grid.columnCount();
        var i;

        for( var i = 0; i < totalcol; i++ ){
          var col =  grid.getColumnObject(i).getxdatafld();
          gc[col]=i;
        }
        
    }





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
     
        
        
        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchname',searchname);
	grid.getDataSource().setGetHandlerParameter('searchuname',searchuname);
	grid.getDataSource().setGetHandlerParameter('searchuser_isactive',searchuser_isactive);
	

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




    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('DataboundGrid');
        g.insertRow();
    }
    function validateEmpty(){

   	var g= nitobi.getGrid('DataboundGrid');
         var total_row = g.getRowCount();
        var  uname= "";
        var  email= "";
        var  pass= "";
        var  pass2= "";
        for( var i = 0; i < total_row; i++ ) {

          uname= g.getCellValue( i, gc['uname']);
          email= g.getCellValue( i, gc['email']);
          pass= g.getCellValue( i, gc['pass']);
          pass2= g.getCellValue( i, gc['pass2']);
          if(pass != pass2)
       
          if(uname=="" || email=="" || pass != pass2){
            
            return false;
            }


        }

        return true;
    }

    //trigger save activity from javascript
   function save()
     {
   	var g= nitobi.getGrid('DataboundGrid');

      if(validateEmpty()){
       
                   g.save();
       
      }
      else{
      document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please make sure user name, email is not empty. If you change password, please reconfirm with correct password</b><br/>";
      }
    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
        if(validateEmpty())
        return true;
        else{
       popup('popUpDiv');
        return false;
        }
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

 
    function checkAllowEdit(eventArgs){
	var g= nitobi.getGrid('DataboundGrid');
        col=eventArgs.getCell().getColumn();
       if($alloweditgrid) //if user have permission to edit the cell, control primary key column read only at here too
        return true;
        else
        return false;

        }


//after insert a new line will automatically fill in some value here

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
     gethandler="user.php?action=search"
     savehandler="user.php?action=save"
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
   <ntb:textcolumn  width="85" label="Full Name" xdatafld="name"  classname="{\$rh}" ></ntb:textcolumn>
   <ntb:textcolumn width="150" label="Email" xdatafld="email" classname="{\$rh}"  ></ntb:textcolumn>
   <ntb:textcolumn label="Active" width="45" xdatafld="user_isactive" sortenabled="true"  classname="{\$rh}">
         <ntb:checkboxeditor datasource="[{value:'1',display:''},{value:'0',display:''}]"
          checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value"></ntb:checkboxeditor>
        </ntb:textcolumn>

   <ntb:textcolumn label="New Password"  width="150" xdatafld="pass"  classname="{\$rh}">
<ntb:passwordeditor></ntb:passwordeditor>
</ntb:textcolumn>
   <ntb:textcolumn label="Reconfirm Password"  width="150" xdatafld="pass2"  classname="{\$rh}">
<ntb:passwordeditor></ntb:passwordeditor>
</ntb:textcolumn>
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

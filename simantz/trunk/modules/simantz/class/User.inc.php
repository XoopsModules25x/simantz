<?php


class User
{

  public $uid;
  public $name;
  public $uname;
  public $email;
  public $pass;
  public $user_user_isactive;
  
  private $xoopsDB;
  private $tableprefix;
  

  private $log;


//constructor
   public function User(){
	global $xoopsDB,$log;
  	$this->xoopsDB=$xoopsDB;
        $this->tablename="sim_users";
	$this->log=$log;
   }
 
 public function fetchUser( $uid) {
	$this->log->showLog(3,"Fetching period detail into class User.php.");
	 $sql="SELECT uid,uname,name,email,user_isactive,pass from sim_users
			where uid=$uid";
	$this->log->showLog(4,"User->fetchUser, before execute:" . $sql . "<br>");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->uname=$row["uname"];
		$this->email=$row["email"];
		$this->name=$row["name"];
		$this->pass= $row['pass'];
                $this->isdeleted=$row['isdeleted'];
		$this->user_isactive=$row['user_isactive'];
   	$this->log->showLog(4,"User->fetchUser,database fetch into class successfully");
	$this->log->showLog(4,"uname:$this->uname");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"User->fetchUser,failed to fetch data into databases:" . mysql_error());
	}
  } // end of member function fetchUser

 public function showSearchForm(){

  global $isadmin;

//  if($isadmin==1)
//  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\" onchange=\"hideadd()\">".
//        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";
  
  echo <<< EOF
<table style="width:100%;" > 
 <tr>
  <td align="center">
 <form name="frmUser" onsubmit="search();return false;">

<table id='centercontainer' class="searchformblock" style="width:943px;">
 <tr><td nowrap>

    <div align="center" class="tdListRightTitle">Search User</div>

            <div class="divfield" style="width:250px"><label>User Name &nbsp;
			<input name="searchuname" id="searchuname" ></label></div>
           <div class="divfield" style="width:250px"><label>Full Name &nbsp;
			<input name="searchname" id="searchname" ></label></div>
	    <div class="divfield" style="width:120px"> <label>Active &nbsp;
                <select name="searchuser_isactive" id="searchuser_isactive">
                    <option value="-">Null</option>
                    <option value="1" SELECTED="SELECTED">Yes</option>
                    <option value="0">No</option>
                </select></label></div>
           <div class="divfield" style="text-align:right; width:160px"> <input name="submit" value="Search" type="submit" ></div>
 </td></tr>
</table>
</form>
</td></tr></table>
EOF;
}

 public function getUserform(){
     global $nitobigridthemes,$havewriteperm,$isadmin;

if($havewriteperm==1){ //user with write permission can edit grid, have button
   $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $permsetctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesaveSET()\"";
   $savectrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
              <input name="btnSave" onclick="save()" value="Save" type="button">';
   $savesettingctrl='<input name="btnAddsetting" id="btnAddsetting"  onclick="addlinesetting()" value="Add New Setting" type="button" style="display:none">
                          <input name="btnSavesetting" id="btnSavesetting" onclick="savesetting()" value="Save Setting" type="button" style="display:none">';
   $alloweditgrid= "true";
}
else{ //user dun have write permission, cannot save grid
   $savectrl="";
   $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $permsetctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $alloweditgrid= "false";
}
 echo <<< EOF

  <script language="javascript" type="text/javascript">
    var gc = new Array();
    var gcset = new Array();
    jQuery(document).ready((function (){
        nitobi.loadComponent('DataboundGrid');
        nitobi.loadComponent('DataboundGridSET');
        getgridcol();
        getgridsetcol();
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
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
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
//          if(pass != pass2)
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
	   return true;
	}else{
	   document.getElementById("afterconfirm").value=0;
	   return false;
	}
     }

///Start Setting

    function getgridsetcol(){
        var grid = nitobi.getGrid("DataboundGridSET");
        var totalcol = grid.columnCount();
        var i;
        for( var i = 0; i < totalcol; i++ ){
          var col =  grid.getColumnObject(i).getxdatafld();
          gcset[col]=i;
        }
    }

    function ChooseSetting(eventArgs)
	{
		var myRow = eventArgs.cell.getRow();
		var myMasterGrid = nitobi.getComponent('DataboundGrid');
		var uid = myMasterGrid.getCellObject(myRow,gc['uid']).getValue();

                if(uid!="" || uid!="0"){
                  document.getElementById("btnAddsetting").style.display="inline";
                  document.getElementById("btnSavesetting").style.display="inline";
                }else{
                  document.getElementById("btnAddsetting").style.display="none";
                  document.getElementById("btnSavesetting").style.display="none";
                }

                if(document.getElementById("uid").value!=uid){
                  document.getElementById("uid").value=uid;
		  var myDetailGrid = nitobi.getComponent('DataboundGridSET');
		  myDetailGrid.getDataSource().setGetHandlerParameter('uid', uid);
		  myDetailGrid.dataBind();
                }
     }

    function datareadySET(){
       var  g = nitobi.getGrid('DataboundGridSET');
       g.move(0,1);//need to trigger relative position 0,0 in for next code able to highlight at screen
       var selRow = g.getSelectedRow();
    }

    function showErrorSET(){
        var grid= nitobi.getGrid('DataboundGridSET');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();
       if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<b style=\"color:red\">"+errorMessage+"</b><br/>";
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }

    function addlinesetting(){
    var g= nitobi.getGrid('DataboundGridSET');
        g.insertRow();
    }

    function setDefaultValueSET(eventArgs)
    {
      var myGrid = eventArgs.getSource();
      var r = eventArgs.getRow();
      var rowNo = r.Row;
      var uid = document.getElementById('uid').value;
      myGrid.getCellObject(rowNo,gcset['isactive']).setValue(1);
      myGrid.getCellObject(rowNo,gcset['uid']).setValue(uid);
      myGrid.selectCellByCoords(rowNo, 1);
    }

    function beforesaveSET(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
        return true;
    }

    function savedoneSET(eventArgs){
        var grid= nitobi.getGrid('DataboundGridSET');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();
        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="Record save successfully";
                         searchsetting();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	searchsetting();
                popup('popUpDiv');
        	return false;
        	}
    }

    function savesetting(){
      if(validateEmptySET()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DataboundGridSET');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
     	  var g= nitobi.getGrid('DataboundGridSET');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
    	   }
	 }
      }
    }

    function validateEmptySET(){
        var grid= nitobi.getGrid('DataboundGridSET');
        var isallow = true;
        var total_row = grid.getRowCount();
        var name ="";
        var code ="";
        var condition ="";
        var uid =""

        for( var i = 0; i < total_row; i++ ) {
        var namecell = grid.getCellObject( i, gcset['usersetting_name']);//1st para : row , 2nd para : column seq
        var codecell = grid.getCellObject( i,gcset['usersetting_code']);//1st para : row , 2nd para : column seq
        var conditioncell = grid.getCellObject( i,gcset['usersetting_condintion']);//1st para : row , 2nd para : column seq
        var uidcell = grid.getCellObject( i,gcset['uid']);//1st para : row , 2nd para : column seq
            name = namecell.getValue();
            code = codecell.getValue();
            condition = conditioncell.getValue();
            uid = uidcell.getValue();

           if(condition=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Condition.</b><br/>";
           }
           if(code=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Code.</b><br/>";
           }
           if(name=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Setting Name.</b><br/>";
           }
           if(uid=="" || uid==0)
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">No detect User are select. Please Click the user agian.</b><br/>";
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }

    function onclickdeletebuttonSET(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('DataboundGridSET');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
           alert("Please choose a row before deleting.");
           return false;
        }
        else
           g.deleteCurrentRow();
    }

    function viewlogSET(){
   	var g= nitobi.getGrid('DataboundGridSET');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, selCol);
      window.open(cellObj,"");
    }

    function searchsetting(){
        var grid = nitobi.getGrid("DataboundGridSET");
        var uid=document.getElementById("uid").value;
	grid.getDataSource().setGetHandlerParameter('uid',uid);
        //reload grid data
	grid.dataBind();
    }
</script>
<div align="center">
<input type="hidden" id="uid" value="0">
<table style="width:700px;">
<tr><td align="left" class="tdListRightTitle">$savectrl</td></tr>

<tr><td align="center">
<div>
<ntb:grid id="DataboundGrid"
     mode="nonpaging"
     toolbarenabled='false'
     $permctrl
     singleclickeditenabled="false"
     onhtmlreadyevent="dataready()"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="user.php?action=search"
     savehandler="user.php?action=save"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     oncellclickevent="ChooseSetting(eventArgs)"
     rowhighlightenabled="true"
     width="943"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes">
 <ntb:columns>
   <ntb:numbercolumn   label="ID"  width="0"  visible="false" xdatafld="uid" mask="###0" sortenabled="false"></ntb:numbercolumn>
   <ntb:textcolumn width="210" label="User Name" xdatafld="uname"  classname="{\$rh}"></ntb:textcolumn>
   <ntb:textcolumn  width="85" label="Full Name" xdatafld="name"  classname="{\$rh}" ></ntb:textcolumn>
   <ntb:textcolumn width="150" label="Email" xdatafld="email" classname="{\$rh}"  ></ntb:textcolumn>
   <ntb:textcolumn label="Active" width="45" xdatafld="user_isactive" sortenabled="true"  classname="{\$rh}">
         <ntb:checkboxeditor datasource="[{value:'1',display:''},{value:'0',display:''}]"
          checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value"></ntb:checkboxeditor>
        </ntb:textcolumn>
   <ntb:textcolumn label="New Password"  width="150" xdatafld="pass"  classname="{\$rh}"><ntb:passwordeditor></ntb:passwordeditor></ntb:textcolumn>
   <ntb:textcolumn label="Reconfirm Password"  width="150" xdatafld="pass2"  classname="{\$rh}"><ntb:passwordeditor></ntb:passwordeditor></ntb:textcolumn>
   <ntb:textcolumn  label="Del"   xdatafld=""  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebutton()">
            <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>
</ntb:columns>
</ntb:grid>
    </div>
</td></tr>

<tr>
   <td align="left" class="tdListRightTitle">
    <table>
     <tr>
      <td align="left">$savesettingctrl</td>
      <td align="center">User Addition Setting</td>
      <td></td>
     </tr>
    </table>
   </td>
</tr>

<tr><td align="center">
<div>
<ntb:grid id="DataboundGridSET"
     mode="nonpaging"
     toolbarenabled='false'
     $permsetctrl
     singleclickeditenabled="true"
     onhtmlreadyevent="datareadySET()"
     onhandlererrorevent="showErrorSET()"
     gethandler="user.php?action=searchsetting"
     savehandler="user.php?action=savesetting"
     onafterrowinsertevent="setDefaultValueSET(eventArgs)"
     rowhighlightenabled="true"
     width="943"
     height="150"
     rowheight="50"
     onaftersaveevent="savedoneSET(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="saveSET()"
     autosaveenabled="false"
     theme="$nitobigridthemes">
 <ntb:columns>
   <ntb:numbercolumn   label="ID"  width="0"  visible="false" xdatafld="usersetting_id" mask="###0" sortenabled="false"></ntb:numbercolumn>
   <ntb:numbercolumn   label="uid"  width="0"  visible="false" xdatafld="uid" mask="###0" sortenabled="false"></ntb:numbercolumn>
   <ntb:textcolumn width="210" label="Setting Name" xdatafld="usersetting_name"  classname="{\$rh}"></ntb:textcolumn>
   <ntb:textcolumn  width="85" label="Code" xdatafld="usersetting_code"  classname="{\$rh}" ></ntb:textcolumn>
   <ntb:textcolumn width="350" label="Condition" xdatafld="usersetting_condintion" classname="{\$rh}"  ><ntb:textareaeditor></ntb:textareaeditor></ntb:textcolumn>
   <ntb:textcolumn label="Active" width="45" xdatafld="isactive" sortenabled="true"  classname="{\$rh}">
         <ntb:checkboxeditor datasource="[{value:'1',display:''},{value:'0',display:''}]"
          checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value"></ntb:checkboxeditor>
        </ntb:textcolumn>
   <ntb:textcolumn  label="Del" width="25"  xdatafld=""  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebuttonSET()">
            <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>

EOF;
//only admin user will see record info and isdeleted column
if($isadmin==1)
{
echo<<< EOF
  <ntb:textcolumn  label="Log"   xdatafld="info"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlogSET()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>
EOF;
}
 echo <<< EOF

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


 }


 public function showUser($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin,$uid;

    $tablename="sim_users";
    $searchname=$_GET['searchname'];
    $searchuname=$_GET['searchuname'];
    $searchuser_isactive=$_GET['searchuser_isactive'];

   $this->log->showLog(2,"Access ShowUser($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="uname,name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     if($searchname !="")
           $wherestring.= " AND name LIKE '%".$searchname."%'";
     if($searchuname !="")
           $wherestring.= " AND uname LIKE '%".$searchuname."%'";
     if($searchuser_isactive !="-" && $searchuser_isactive !="")
           $wherestring.= " AND user_isactive =$searchuser_isactive";

if($uid>1)
    $wherestring.= " and uid >1";

     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("name");
     	$getHandler->DefineField("uname");
     	$getHandler->DefineField("user_isactive");
        $getHandler->DefineField("pass");
        $getHandler->DefineField("pass2");
        $getHandler->DefineField("info");
        $getHandler->DefineField("email");
        $getHandler->DefineField("uid");
        $getHandler->DefineField("rh");

	$currentRecord = 0; // This will assist us finding the ordinalStart position
            $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {

          if($rh=="even")
            $rh="odd";
          else
            $rh="even";

     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['uid']);
             $getHandler->DefineRecordFieldValue("name", $row['name']);
             $getHandler->DefineRecordFieldValue("uname",$row['uname']);
             $getHandler->DefineRecordFieldValue("user_isactive", $row['user_isactive']);
             $getHandler->DefineRecordFieldValue("pass", "");
             $getHandler->DefineRecordFieldValue("pass2", "");
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['uid']."&tablename=sim_users&idname=uid&title=User");
             $getHandler->DefineRecordFieldValue("email",$row['email']);
             $getHandler->DefineRecordFieldValue("uid",$row['uid']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showUser(),uid=$uid");
    }

 public function saveUser(){
    $this->log->showLog(2,"Access saveUser");
        include "../simantz/class/nitobi.xml.php";
        include_once "../simantz/class/Save_Data.inc.php";

        global $xoopsDB,$xoopsUser;
        $saveHandler = new EBASaveHandler();
        $saveHandler->ProcessRecords();
        $timestamp=date("Y-m-d H:i:s",time());
        $createdby=$xoopsUser->getVar('uid');
        $uname=$xoopsUser->getVar('uname');
        $uid=$xoopsUser->getVar('uid');
        $organization=$xoopsUser->getVar('uid');
        $organization_id=$this->defaultorganization_id;
       $tablename="sim_users";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {
 $pass =  trim($saveHandler->ReturnInsertField($currentRecord,"pass"));
 if($pass==""){
    $arrfield=array("name", "uname","user_isactive","email");
    $arrfieldtype=array('%s','%s','%d','%s');
     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "name"),
                $saveHandler->ReturnInsertField($currentRecord, "uname"),
                $saveHandler->ReturnInsertField($currentRecord,"user_isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"email")
         );

 }
 else{
    $arrfield=array("name", "uname","user_isactive","pass","email");
    $arrfieldtype=array('%s','%s','%d','%s','%s');
     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "name"),
                $saveHandler->ReturnInsertField($currentRecord, "uname"),
                $saveHandler->ReturnInsertField($currentRecord,"user_isactive"),
                md5($saveHandler->ReturnInsertField($currentRecord,"pass")),
                $saveHandler->ReturnInsertField($currentRecord,"email")
         );

 }
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "name");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"uid");
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{

 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {
       $pass =  trim($saveHandler->ReturnUpdateField($currentRecord,"pass"));
         if($pass==""){
          $arrfield=array("name", "uname", "user_isactive", "email");
          $arrfieldtype=array('%s','%s','%d','%s');
        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "name"),
                $saveHandler->ReturnUpdateField($currentRecord, "uname"),
                $saveHandler->ReturnUpdateField($currentRecord,"user_isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"email"),
                );

         }
         else{
          $arrfield=array("name", "uname", "user_isactive","pass", "email");
          $arrfieldtype=array('%s','%s','%d','%s','%s');
        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "name"),
                $saveHandler->ReturnUpdateField($currentRecord, "uname"),
                $saveHandler->ReturnUpdateField($currentRecord,"user_isactive"),
                md5($saveHandler->ReturnUpdateField($currentRecord,"pass")),
                $saveHandler->ReturnUpdateField($currentRecord,"email"),
                );

         }


        $this->log->showLog(3,"***updating record($currentRecord),new uname:".
              $saveHandler->ReturnUpdateField($currentRecord, "uname").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"uid")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "name");

         $save->UpdateRecord($tablename, "uid", $saveHandler->ReturnUpdateField($currentRecord,"uid"),
                    $arrfield, $arrvalue, $arrfieldtype,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }

 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
//include "class/User.inc.php";
//$o = new User();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchUser($record_id);
    $controlvalue=$this->name;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_users","uid",$record_id,$controlvalue,1);

  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
  }

  }
//$this->failfeedback.="asdasdpasd<br/>\n";
//$this->failfeedback.="123 3443<br/>\n";
//$this->failfeedback.="234 45656523 234<br/>\n";
//if($this->failfeedback!="")
//    $this->failfeedback .= $this->failfeedback."\n";



  $saveHandler->setErrorMessage($this->failfeedback);
//$this->failfeedback.="Warning!<br/>\n".$this->failfeedback;

$saveHandler->CompleteSave();

}

 public function showSetting($wherestring){
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;
    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

    $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];

    $tablename="sim_usersetting";
    $uid=$_GET['uid'];

   $this->log->showLog(2,"Access showSetting($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="usersetting_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
     $wherestring.= " AND uid ='$uid'";

     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("usersetting_id");
        $getHandler->DefineField("uid");
     	$getHandler->DefineField("usersetting_name");
        $getHandler->DefineField("usersetting_code");
        $getHandler->DefineField("usersetting_condintion");
        $getHandler->DefineField("isactive");
        $getHandler->DefineField("info");
        $getHandler->DefineField("rh");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
            $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {
          if($rh=="even")
            $rh="odd";
          else
            $rh="even";
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['usersetting_id']);
             $getHandler->DefineRecordFieldValue("uid", $row['uid']);
             $getHandler->DefineRecordFieldValue("usersetting_id", $row['usersetting_id']);
             $getHandler->DefineRecordFieldValue("usersetting_name", $row['usersetting_name']);
             $getHandler->DefineRecordFieldValue("usersetting_code", $row['usersetting_code']);
             $getHandler->DefineRecordFieldValue("usersetting_condintion", $row['usersetting_condintion']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['usersetting_id']."&tablename=sim_usersetting&idname=usersetting_id&title=User Setting");
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
          $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showSetting()");
    }

 public function saveSetting(){
    $this->log->showLog(2,"Access saveSetting");
        include "../simantz/class/nitobi.xml.php";
        include_once "../simantz/class/Save_Data.inc.php";

        global $xoopsDB,$xoopsUser;
        $saveHandler = new EBASaveHandler();
        $saveHandler->ProcessRecords();
        $timestamp=date("Y-m-d H:i:s",time());
        $createdby=$xoopsUser->getVar('uid');
        $uname=$xoopsUser->getVar('uname');
        $uid=$xoopsUser->getVar('uid');

        $organization_id=$this->defaultorganization_id;
        $tablename="sim_usersetting";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("uid","usersetting_name","usersetting_code","usersetting_condintion","isactive",
                    "created","createdby","updated","updatedby");
    $arrfieldtype=array('%d','%s','%s','%s','%d','%s','%d','%s','%d');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord,"uid"),
                     $saveHandler->ReturnInsertField($currentRecord,"usersetting_name"),
                     $saveHandler->ReturnInsertField($currentRecord,"usersetting_code"),
                     $saveHandler->ReturnInsertField($currentRecord,"usersetting_condintion"),
                     $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                     $timestamp,
                     $createdby,
                     $timestamp,
                     $createdby);
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "usersetting_code")." - ".$saveHandler->ReturnInsertField($currentRecord,"usersetting_name");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"usersetting_id");
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
  // Now we execute this query
 }
}

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{
    $arrfield=array("usersetting_name","usersetting_code","usersetting_condintion","isactive",
                    "updated","updatedby");
    $arrfieldtype=array('%s','%s','%s','%d','%s','%d');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {
     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord,"usersetting_name"),
                     $saveHandler->ReturnInsertField($currentRecord,"usersetting_code"),
                     $saveHandler->ReturnInsertField($currentRecord,"usersetting_condintion"),
                     $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                     $timestamp,
                     $createdby);
     
        $this->log->showLog(3,"***updating record($currentRecord),new usersetting_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "usersetting_name").",usersetting_code:".
              $saveHandler->ReturnUpdateField($currentRecord,"usersetting_code")."\n");
        $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "usersetting_code")." - ". $saveHandler->ReturnUpdateField($currentRecord,"usersetting_name");
        $save->UpdateRecord($tablename,"usersetting_id",$saveHandler->ReturnUpdateField($currentRecord,"usersetting_id"),$arrfield, $arrvalue, $arrfieldtype,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }
 }
}

$ispurge=0;
$deleteCount = $saveHandler->ReturnDeleteCount();
$this->log->showLog(3,"Start delete/purge($deleteCount records)");
//include "class/Currency.inc.php";
//$o = new Currency();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $save->DeleteRecord("sime_usersetting","usersetting_id",$record_id,$controlvalue,1);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
    }
  }
}
if($this->failfeedback!="")
$this->failfeedback="Warning!<br/>\n".$this->failfeedback;

$saveHandler->setErrorMessage($this->failfeedback);
$saveHandler->CompleteSave();


}

 public function showLookupUser(){
        $this->log->showLog(2,"Run lookup showUser()");
        $tablename="sim_users";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  uid, name, uname, user_isactive,pass
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["uid"]);
                       $getHandler->DefineRecordFieldValue("uid", $row["uid"]);
                       $getHandler->DefineRecordFieldValue("uname", $row["uname"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
$getHandler->completeGet();
    }

 public function getUserArray($periodfrom_id,$periodto_id){
      global $tableperiod;
           $this->fetchUser($periodfrom_id);
          $periodfrom=$this->uname;

           $this->fetchUser($periodto_id);
          $periodto=$this->uname;

        $sql="SELECT uid,uname from $tableperiod
                where uname between '$periodfrom' and '$periodto' order by uname ASC";
          $query=$this->xoopsDB->query($sql);
          $data=array();
          while($row=$this->xoopsDB->fetchArray($query))
          $data[]=$row['uid'];
	return $data;
       }

 public function getUserID($year,$month){
        $sql="SELECT uid from $this->tableperiod
                where name =$year and email=$month order by uname ASC";
          $query=$this->xoopsDB->query($sql);
          $data=array();
          while($row=$this->xoopsDB->fetchArray($query))
          return $row['uid'];
	return 0;
       }
 
} // end of ClassJobposition
?>

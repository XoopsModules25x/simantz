<?php


class Group
{

  public $groupid;
  public $name;
  public $group_code;
  public $organization_id;
  public $isactive;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablegroup;
  private $tablebpartner;

  private $log;


//constructor
   public function Group(){

       
       global $xoopsDB,$log,$tablegroup,$tablebpartner,$tablebpartnergroup,$tableorganization,$tabledailyreport,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
	$this->tableorganization=$tableorganization;
	$this->tablegroup=$tablegroup;
	$this->tablebpartner=$tablebpartner;
	$this->tabledailyreport=$tabledailyreport;
	$this->log=$log;
   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int groupid
   * @return
   * @access public
   */

  public function fetchGroup($groupid) {
	$this->log->showLog(3,"Fetching group detail into class Group.inc.php.<br>");

	$sql="SELECT * from $this->tablegroup where groupid=$groupid";

	$this->log->showLog(4,"ProductGroup->fetchGroup, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->name=$row["name"];
		$this->group_code=$row["group_code"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->citizenship=$row['citizenship'];
		$this->isactive=$row['isactive'];
		$this->citizenship=$row['citizenship'];
   	$this->log->showLog(4,"Group->fetchGroup,database fetch into class successfully");
	$this->log->showLog(4,"name:$this->name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Group->fetchGroup,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchGroup

  public function fetchGroupline($groupline_id) {
	$this->log->showLog(3,"Fetching groupline detail into class Group.php.<br>");

	$sql="SELECT * from sim_groupline where groupline_id=$groupline_id";

	$this->log->showLog(4,"ProductGroupline->fetchGroupline, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->groupline_name=$row["groupline_name"];
		$this->organization_id=$row['organization_id'];
		$this->seqno= $row['seqno'];
		$this->isactive=$row['isactive'];

   	$this->log->showLog(4,"groupline->fetchGroupline,database fetch into class successfully");
	$this->log->showLog(4,"groupline_name:$this->groupline_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	//$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Group->fetchGroup,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchGroup

  public function showSearchForm(){

  global $isadmin;

  if($isadmin==1)
  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\">".
        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";

  echo <<< EOF
<table style="width:100%; display:none;" >
 <tr>
  <td align="center" >

<div id='centercontainer' class="searchformblock" style="width:943px;">
       <form name="frmGroup">

    <div align="center" class="searchformheader">Search Employee Group</div>

            <div class="divfield">Employee Group No<br/>
			<input name="searchgroup_code" id="searchgroup_code"></div>

            <div  class="divfield">Employee Group Name<br/>
			<input name="searchname" id="searchname"></div>

	    <div class="divfield"> Active<br/>
                <select name="searchisactive" id="searchisactive">
                    <option value="-">Null</option>
                    <option value="1" SELECTED="SELECTED">Yes</option>
                    <option value="0">No</option>
                </select></div><br/>
        $showdeleted   <input name="submit" value="Search" type="button" onclick="search()">
</form>
    </div>

</td></tr></table>

EOF;
}

  public function getGroup(){
  global $nitobigridthemes,$isadmin,$havewriteperm;

$grIdColumn=0;
$grIdColumnGroupline=0;
$seqid=4;

if($havewriteperm==1){ //user with write permission can edit grid, have button

   $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $permctrlgroupline=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $savectrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
              <input name="btnSave" onclick="save()" value="Save" type="button">';
   $savegrouplinectrl= '<input name="btnSavegroupline" id="btnSavegroupline" onclick="savegroupline()" value="Save" type="button" style="display:none">';
    // <input name="btnDelete" onclick="onclickdeletebutton()" value="Delete" type="button">
    $alloweditgrid= "col!=$grIdColumn";
}
else{ //user dun have write permission, cannot save grid
   $savectrl="";
   $savegrouplinectrl="";
   $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $permctrlgroupline=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $alloweditgrid= "false";
}
 echo <<< EOF
<link rel="stylesheet" type="text/css" href="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.css" />
<script type="text/javascript" src="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.js"></script>
  <script language="javascript" type="text/javascript">
var gc = new Array();
    jQuery(document).ready((function ()
        {nitobi.loadComponent('DataboundGrid');
         nitobi.loadComponent('DetailGrid');
        getgridcol();
        }
    ));

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
	grid.dataBind();
    }

    function searchgroupline(){
        var grid = nitobi.getGrid("DetailGrid");
        var groupid=document.getElementById("groupid").value;
        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('groupid',groupid);
        //reload grid data
	grid.dataBind();
    }

    //after grid html render properly, set focus on it. It is important when use choose particular cell but
    // immediately press search again. From screen we won't detect cell is selected infact from javascript
    // detect selected
    function dataready(grids){
       var  g = nitobi.getGrid(grids);
        if(grids=="DataboundGrid")
          g.move(0,1);//need to trigger relative position 0,0 in for next code able to highlight at screen
        else if(grids=="DetailGrid")
          g.move(0,2);

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

    function savedonegroupline(eventArgs){
        var grid= nitobi.getGrid('DetailGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();
        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="Record save successfully";  
                         searchgroupline();
                         popup('popUpDiv');
		});
           return true;
        }
        else{ //save failed
        	searchgroupline();
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

    //if save_data have error, trigger this function
    function showErrorgroupline(){

        var grid= nitobi.getGrid('DetailGrid');
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

    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){

    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('DataboundGrid');
        g.insertRow();
    }

    function addlinegroupline(){
    var g= nitobi.getGrid('DetailGrid');
        g.insertRow();
    }

    //trigger save activity from javascript
    function save(){
      if(validateEmpty()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DataboundGrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
     	  var g= nitobi.getGrid('DataboundGrid');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
    	   }
	 }
      }
    }

    function savegroupline(){
      if(validateEmptygroupline()){
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DetailGrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
     	  var g= nitobi.getGrid('DetailGrid');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
    	   }
	 }
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
         
         document.getElementById("btnSavegroupline").style.display="none";
        }
    }

    function onclickdeletebuttongroupline(){ //when press delete button will triger this function and ask for confirmation
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
    myGrid.getCellObject(rowNo,6).setValue(10);
    myGrid.getCellObject(rowNo,3).setValue(0);
    myGrid.selectCellByCoords(rowNo, 1);
   }

   function setDefaultValuegroupline(eventArgs)
   {
    var myGrid = eventArgs.getSource();
    var r = eventArgs.getRow();
    var rowNo = r.Row;
    getgroupid = document.getElementById("groupid").value;
    myGrid.getCellObject(rowNo,1).setValue(getgroupid);
    myGrid.getCellObject(rowNo,2).setValue(10);
    myGrid.selectCellByCoords(rowNo, 2);
   }

   function beforeDelete(){
	if(confirm('Delete this record? Data will save into database immediately.')){
	   document.getElementById("afterconfirm").value=1;
	   return true;
	}else{
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

    function viewloggroupline(){
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

        for( var i = 0; i < total_row; i++ ) {
        var codecell = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq
            code = codecell.getValue();
           if(code=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please enter Group Code.</b><br/>";
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }

    function validateEmptygroupline(){

        var grid= nitobi.getGrid('DetailGrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var name ="";

        for( var i = 0; i < total_row; i++ ) {
        var namecell = grid.getCellObject( i, 2);//1st para : row , 2nd para : column seq

           name = namecell.getValue();
           if(name=="0")
           {
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Please Select Group Code for Convert.</b><br/>";
            isallow = false;
           }
        }
        if(isallow)
          return true;
        else
          return false;
    }

    function viewgrouppermission(){

   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var selCol = g.getSelectedColumn();
        var cellObj = g.getCellValue(selRow, gc['setpermission']);
      window.open(cellObj,"");
    }


    function ChooseGroupline(eventArgs)
	{ 
		var myRow = eventArgs.cell.getRow();
		var myMasterGrid = nitobi.getComponent('DataboundGrid');
		var groupid = myMasterGrid.getCellObject(myRow,$grIdColumn).getValue();

                if(groupid!="" || groupid!="0"){
                  
                  document.getElementById("btnSavegroupline").style.display="inline";
                }else{
                  
                  document.getElementById("btnSavegroupline").style.display="none";
                }

                if(document.getElementById("groupid").value!=groupid){
                  document.getElementById("groupid").value=groupid;
		  var myDetailGrid = nitobi.getComponent('DetailGrid');
		  myDetailGrid.getDataSource().setGetHandlerParameter('groupid', groupid);
		  myDetailGrid.dataBind();
                }
     }


</script>
<br/>

<div align="center">
<table style="width:700px;">

<tr><td align="left" style="height:27px;">$savectrl</td>
   <td align="left" style="height:27px;">$savegrouplinectrl</td></tr>
<input type="hidden" name="groupid" id="groupid" value="">
<tr><td align="left">
<div>
<ntb:grid id="DataboundGrid"
     mode="nonpaging"
     toolbarenabled='false'
     $permctrl
     singleclickeditenabled="false"
     onhtmlreadyevent="dataready('DataboundGrid')"
     onhandlererrorevent="showError()"
     gethandler="group.php?action=search"
     savehandler="group.php?action=save"
     oncellclickevent="ChooseGroupline(eventArgs)"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     onafterrowinsertevent="setDefaultValue(eventArgs)"
     rowhighlightenabled="true"
     width="430"
     height="550"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes">

 <ntb:columns>
   <ntb:numbercolumn   label="ID"  width="0" visible="false" xdatafld="groupid" mask="###0" sortenabled="false" editable="false" ></ntb:numbercolumn>
   <ntb:textcolumn  width="110" label="Name" xdatafld="name"  classname="{\$rh}"></ntb:textcolumn>
   <ntb:textcolumn  width="200" label="Description" xdatafld="description" classname="{\$rh}" ></ntb:textcolumn>
<ntb:textcolumn  width="30" label="Perm" xdatafld="setpermission" classname="{\$rh}"  oncelldblclickevent="javascript:viewgrouppermission()">
        <ntb:imageeditor imageurl="images/list.gif"></ntb:imageeditor>
</ntb:textcolumn>
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
             $permctrlgroupline
             ondatareadyevent="dataready('DetailGrid');"
             onhandlererrorevent="showErrorgroupline()"
             singleclickeditenabled="true"
             onafterrowinsertevent="setDefaultValuegroupline(eventArgs)"
             gethandler="group.php?action=searchgroupline"
             savehandler="group.php?action=savegroupline"
             rowhighlightenabled="true"
             width="470"
             height="550"
             
             onaftersaveevent="savedonegroupline(eventArgs)"
             onbeforerowdeleteevent="beforeDelete()"
             onafterrowdeleteevent="savegroupline()"
             autosaveenabled="false"
             theme="$nitobigridthemes"
             >

<ntb:columns>
    
<ntb:numbercolumn   label="uid"  visible="false" width="0" xdatafld="uid" sortenabled="true" editable="false"></ntb:numbercolumn>
<ntb:numbercolumn   label="group"  visible="false" width="0" xdatafld="groupid" sortenabled="true" editable="false"></ntb:numbercolumn>
<ntb:numbercolumn   label="No"  classname="{\$rh}"  width="30" xdatafld="no" sortenabled="true" mask="#"  editable="false"></ntb:numbercolumn>
   <ntb:textcolumn   label="User"  classname="{\$rh}" width="100" xdatafld="uname" sortenabled="true"  editable="false"></ntb:textcolumn>
   <ntb:textcolumn   label="Full Name"  classname="{\$rh}" width="140" xdatafld="name" sortenabled="true"  editable="false"></ntb:textcolumn>
   <ntb:textcolumn   label="Email"  classname="{\$rh}" width="150" xdatafld="email" sortenabled="true"  editable="false"></ntb:textcolumn>
   <ntb:textcolumn width="45" classname="{\$rh}" label="Select"  xdatafld="selectrow" sortenabled="false" align="center">
            <ntb:checkboxeditor datasource="[{valuedd:'1',displaydd:''},{valuedd:'0',displaydd:''}]"
                    checkedvalue="1" uncheckedvalue="0" displayfields="displaydd" valuefield="valuedd">
           </ntb:checkboxeditor>
              <ntb:numbercolumn   label="linkid "  visible="false" width="0" xdatafld="groupline_id"  editable="false"></ntb:numbercolumn>
    </ntb:textcolumn>
</ntb:columns>
         </ntb:grid>
 </td>

</tr>
<tr><td align="left">
  <input id='afterconfirm' value='0' type='hidden'>

<div id="msgbox" class="statusmsg"></div>
</td></tr></table></div>
EOF;

  }

  public function showGroup($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin,$uid;

    $tablename="sim_groups";
    $searchgroup_code=$_GET['searchgroup_code'];
    $searchname=$_GET['searchname'];
    

   $this->log->showLog(2,"Access ShowGroup($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
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

     if($searchname !="")
           $wherestring.= " AND name LIKE '".$searchname."'";
    // if($searchisactive !="-")
         //  $wherestring.= " AND isactive =$searchisactive";
     if($uid>1)
         $wherestring.=" and groupid>1";

     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        
     	$getHandler->DefineField("name");
        $getHandler->DefineField("description");
        $getHandler->DefineField("groupid");
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
             $getHandler->CreateNewRecord($row['groupid']);
             
             $getHandler->DefineRecordFieldValue("name",$row['name']);
             $getHandler->DefineRecordFieldValue("description", $row['description']);
             $getHandler->DefineRecordFieldValue("groupid",$row['groupid']);
             $getHandler->DefineRecordFieldValue("setpermission","permission.php?action=search&groupid=".$row['groupid']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showGroup()");
    }

  public function saveGroup(){
    $this->log->showLog(2,"Access saveGroup");
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
        $tablename="sim_groups";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("name", "description");
    $arrfieldtype=array('%s','%s');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array(
                
                $saveHandler->ReturnInsertField($currentRecord,"name"),
                $saveHandler->ReturnInsertField($currentRecord,"description"),);

     $controlvalue=$saveHandler->ReturnInsertField($currentRecord,"name");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"groupid");
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
   $arrfield=array("name","description");
    $arrfieldtype=array('%s','%s');
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {
        $arrvalue=array(
                
                $saveHandler->ReturnUpdateField($currentRecord,"name"),
                $saveHandler->ReturnUpdateField($currentRecord,"description"),);
                
        $this->log->showLog(3,"***updating record($currentRecord),new name:".
              $saveHandler->ReturnUpdateField($currentRecord, "name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"groupid")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "name");
         $save->UpdateRecord($tablename, "groupid", $saveHandler->ReturnUpdateField($currentRecord,"groupid"),
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

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $save->DeleteRecord("sim_groups","groupid",$record_id,$controlvalue,1);
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

  public function showGroupline($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin,$uid;

    $tablename="sim_groups_users_link";
    $groupid=$_GET['groupid'];


   $this->log->showLog(2,"Access ShowGroupline($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="u.uname";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

        if($uid>1)
         $wherestring=" WHERE u.uid>1";
       else
           $wherestring="";

     $sql = "SELECT u.uname,u.name,u.email,u.uid, (select max(linkid) as linkid from $tablename gl where gl.uid=u.uid and gl.groupid=$groupid) as linkid
                from sim_users u $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("name");
     	$getHandler->DefineField("linkid");
        $getHandler->DefineField("uid");
        $getHandler->DefineField("groupid");
        $getHandler->DefineField("uname");
        $getHandler->DefineField("email");
        $getHandler->DefineField("selectrow");
        
        $getHandler->DefineField("rh");

	$currentRecord = 0; // This will assist us finding the ordinalStart position
            $rh="odd";
            $i=0;
      while ($row=$xoopsDB->fetchArray($query))
     {$i++;

          if($rh=="even")
            $rh="odd";
          else
            $rh="even";

            if($row['linkid']=="")
                $selectrow=0;
            else
                $selectrow=1;

            
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($i);
             $getHandler->DefineRecordFieldValue("no", $i);
             $getHandler->DefineRecordFieldValue("linkid", $row['linkid']);
             $getHandler->DefineRecordFieldValue("uname", $row['uname']);
             $getHandler->DefineRecordFieldValue("name", $row['name']);
             $getHandler->DefineRecordFieldValue("uid", $row['uid']);
             $getHandler->DefineRecordFieldValue("groupid", $groupid);
             $getHandler->DefineRecordFieldValue("email",$row["email"]);
             $getHandler->DefineRecordFieldValue("selectrow",$selectrow) ;
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showGroupline()");
    }

  public function saveGroupline(){
    $this->log->showLog(2,"Access saveGroupline");
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
        $tablename="sim_groups_users_link";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

$updateCount = $saveHandler->ReturnUpdateCount();
$this->log->showLog(3,"Start update($updateCount records)");

if ($updateCount > 0)
{
  
 // Yes there are UPDATEs to perform...
 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {
     $isselect=$saveHandler->ReturnUpdateField($currentRecord,"selectrow");
     $glid=$saveHandler->ReturnUpdateField($currentRecord,"linkid");
     $cuid=$saveHandler->ReturnUpdateField($currentRecord,"uid");
     $cgroupid=$saveHandler->ReturnUpdateField($currentRecord,"groupid");
     $this->log->showLog(4,"Record:$cuid,$cgroupid,$glid,$isselect");

     if($isselect==0){
          $save->DeleteRecord($tablename,"linkid",$glid,"",1);
     }
     else{
            $arrfield=array("uid","groupid");
            $arrfieldtype=array('%d','%d');
            $arrvalue=array($cuid,$cgroupid);
            $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"uid");
     }
     
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

} // end of ClassGroup
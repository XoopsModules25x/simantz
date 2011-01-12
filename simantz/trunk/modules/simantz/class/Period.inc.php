<?php


class Period
{

  public $jobposition_id;
  public $jobposition_name;
  public $jobposition_no;
  public $department_id;
  public $organization_id;
  public $isactive;
  public $description;
  public $seqno;
  public $created;
  public $createdby;
  public $updated;
  public $updatedby;
  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tablejobposition;
  private $tablebpartner;

  private $log;


//constructor
   public function Period(){
	global $xoopsDB,$log,$defaultorganization_id;
        $this->defaultorganization_id=$defaultorganization_id;
  	$this->xoopsDB=$xoopsDB;
        $this->tablejobposition="sim_hr_jobposition";
	$this->log=$log;
   }
 
  public function fetchPeriod( $period_id) {
	$this->log->showLog(3,"Fetching period detail into class Period.php.");
	 $sql="SELECT period_id,period_name,period_year,period_month,isactive,seqno from sim_period
			where period_id=$period_id";
	$this->log->showLog(4,"Period->fetchPeriod, before execute:" . $sql . "<br>");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->period_name=$row["period_name"];
		$this->period_month=$row["period_month"];
		$this->period_year=$row["period_year"];
		$this->seqno= $row['seqno'];
                $this->isdeleted=$row['isdeleted'];
		$this->isactive=$row['isactive'];
   	$this->log->showLog(4,"Period->fetchPeriod,database fetch into class successfully");
	$this->log->showLog(4,"period_name:$this->period_name");
		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Period->fetchPeriod,failed to fetch data into databases:" . mysql_error());
	}
  } // end of member function fetchPeriod

 public function getPeriodform(){
  global $nitobigridthemes,$isadmin,$havewriteperm;


if($havewriteperm==1){ //user with write permission can edit grid, have button
   $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
   $hidewidth="width='25' visible='true'";
   $savectrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
     <input name="btnSave" onclick="save()" value="Save" type="button">';
   $alloweditgrid="true";
   $generateallyear='<input name="btnAdd" onclick="generate()" value="Generate Full Year Period" type="button">
                     <select name="generateYear" id="generateYear">'.$this->yearctrl.'</select>';
}else{ //user dun have write permission, cannot save grid
   $savectrl="";
   $hidewidth="width='0' visible='false'";
   $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
   $alloweditgrid= "false";
}
 echo <<< EOF

  <script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){nitobi.loadComponent('DataboundGrid');getgridcol();}));

    function init(){}
    var gc = new Array();

    function getgridcol(){
        var grid = nitobi.getGrid("DataboundGrid");
        var totalcol = grid.columnCount();
        var i;
        for( var i = 0; i < totalcol; i++ ){
          var col =  grid.getColumnObject(i).getxdatafld();
          gc[col]=i;
        }
    }

    function generate(){
        var generateYear=document.getElementById("generateYear").value;
        var data="action=generatePeriod&generateYear="+generateYear;

       if(confirm("Confirm Generate Full "+generateYear+" Year Period")){

         $.ajax({
             url: "period.php",type: "POST",data: data,cache: false,
                 success: function (xml) { 
                    jsonObj = eval( '(' + xml + ')');
                    var status = jsonObj.status;
                    var msg = jsonObj.msg;

                         if(status==1){
                            search();
                            document.getElementById('msgbox').innerHTML="Record Generate successfully";
                         }else{

                         }
 
                     }});
       }
    }

    function search(){
        var grid = nitobi.getGrid("DataboundGrid");
        var searchperiod_year=document.getElementById("searchperiod_year").value;
        var searchperiod_name=document.getElementById("searchperiod_name").value;
        var searchisactive=document.getElementById("searchisactive").value;

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        if(document.getElementById("searchisdeleted"))
        var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchperiod_year',searchperiod_year);
	grid.getDataSource().setGetHandlerParameter('searchperiod_name',searchperiod_name);
	grid.getDataSource().setGetHandlerParameter('searchisactive',searchisactive);
	grid.getDataSource().setGetHandlerParameter('searchisdeleted',searchisdeleted);

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
        }else{ //save failed
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


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('DataboundGrid');
        g.insertRow();
    }

    //trigger save activity from javascript
    function save(){

      if(validateEmpty()){
        if(validateMonth()){
                if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
                   var g= nitobi.getGrid('DataboundGrid');
                   document.getElementById("afterconfirm").value=0;
                   g.save();
                }else{ // not yet request confirmation
                  if(confirm("Confirm the changes? Data will save into database immediately")){
                     var g= nitobi.getGrid('DataboundGrid');
                     document.getElementById("afterconfirm").value=0;
                     g.save();
                     search();
                   }
                }
        }else{
             document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Month error, please enter value between 1~12.</b><br/>";
         }
      }else{
            document.getElementById('msgbox').innerHTML="<b style=\"color:red\">Period name, month and year cannot be null</b><br/>";
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
        }else
           g.deleteCurrentRow();
    }

   function onclicklogbutton(){ //when press delete button will triger this function and ask for confirmation
       window.open('','y');
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
   myGrid.getCellObject(rowNo,gc['seqno']).setValue(10);
   myGrid.selectCellByCoords(rowNo, 0);
  }

  function beforeDelete(){
		if(confirm('Delete this record? Data will save into database immediately.')){
			document.getElementById("afterconfirm").value=1;
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
        var namecell = grid.getCellObject( i, gc['period_name']);//1st para : row , 2nd para : column seq
        var monthcell = grid.getCellObject( i, gc['period_month']);//1st para : row , 2nd para : column seq
        var yearcell = grid.getCellObject( i,gc['period_year']);//1st para : row , 2nd para : column seq

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
        var monthcell = grid.getCellObject( i,gc['period_month']);//1st para : row , 2nd para : column seq
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

    function getperiodname(){
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var yearcell = g.getCellObject(selRow,gc['period_year']).getValue();
        var monthcell = g.getCellObject(selRow,gc['period_month']).getValue();
        if(monthcell<10)
           monthcell="0"+monthcell;

        var periodname=yearcell+"-"+monthcell;

        g.getCellObject(selRow,gc['period_name']).setValue(periodname);

    }


</script>
<br/>
     <div id='popupmessage' style='text-align:center'></div>
     <div id='progressimage' style='text-align:center'><img src='../../simantz/images/ajax_indicator_01.gif'></div>
<div align="center">
<table style="width:700px;">

<tr><td align="left" style="height:27px;">$savectrl $generateallyear</td></tr>

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
     onaftercelleditevent="getperiodname()"
     onaftersaveevent="savedone(eventArgs)"
     onbeforerowdeleteevent="beforeDelete()"
     onafterrowdeleteevent="save()"
     autosaveenabled="false"
     theme="$nitobigridthemes">
 <ntb:columns>
   <ntb:numbercolumn   label="ID" visible="false" width="0" xdatafld="period_id" editable="false" mask="###0" sortenabled="false"></ntb:numbercolumn>
   <ntb:numbercolumn  width="85" label="Year" xdatafld="period_year"  classname="{\$rh}" maxLength="4" mask="0000"></ntb:numbercolumn>
   <ntb:numbercolumn width="85" label="Month" xdatafld="period_month" classname="{\$rh}" maxLength="2" mask="###0" ></ntb:numbercolumn>
   <ntb:textcolumn width="210" label="Period Name" xdatafld="period_name"  editable="false" classname="{\$rh}"></ntb:textcolumn>
   <ntb:textcolumn label="Active" width="45" xdatafld="isactive" sortenabled="true"  classname="{\$rh}">
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

 }


 public function showSearchForm(){

  global $isadmin;

//  if($isadmin==1)
//  $showdeleted="<input type=\"checkbox\" name=\"searchisdeleted\" id=\"searchisdeleted\" onchange=\"hideadd()\">".
//        "<a onclick=document.getElementById(\"searchisdeleted\").click() title=\"Show deleted records.\">Show Deleted Only</a>";
  
  echo <<< EOF
<table style="width:100%;" > 
 <tr>
  <td align="center">

<table id='centercontainer' class="searchformblock" style="width:943px;">
 <tr><td nowrap>
       <form name="frmJobposition">

    <div align="center" class="searchformheader">Search Period</div>

           <div class="divfield" style="width:250px"><label>Period Year &nbsp;
			<input name="searchperiod_year" id="searchperiod_year" ></label></div>

            <div class="divfield" style="width:250px"><label>Period Name &nbsp;
			<input name="searchperiod_name" id="searchperiod_name" ></label></div>

	    <div class="divfield" style="width:120px"> <label>Active &nbsp;
                <select name="searchisactive" id="searchisactive">
                    <option value="-">Null</option>
                    <option value="1" SELECTED="SELECTED">Yes</option>
                    <option value="0">No</option>
                </select></label></div>
           <div class="divfield" style="text-align:right; width:160px"> <input name="submit" value="Search" type="button" onclick="search()"></div>
</form>
 </td></tr>
</table>

</td></tr></table>

EOF;
}

 public function showPeriod($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    $tablename="sim_period";
    $searchperiod_year=$_GET['searchperiod_year'];
    $searchperiod_name=$_GET['searchperiod_name'];
    $searchisactive=$_GET['searchisactive'];

   $this->log->showLog(2,"Access ShowPeriod($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="seqno, period_name";
        }
        if(empty($sortdirection)){
           $sortdirection="ASC";
        }

     if($searchperiod_year !="")
           $wherestring.= " AND period_year LIKE '".$searchperiod_year."'";
     if($searchperiod_name !="")
           $wherestring.= " AND period_name LIKE '%".$searchperiod_name."%'";
     if($searchisactive !="-" && $searchisactive !="")
           $wherestring.= " AND isactive =$searchisactive";


     $sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("period_year");
     	$getHandler->DefineField("period_name");
     	$getHandler->DefineField("isactive");
        $getHandler->DefineField("seqno");
        $getHandler->DefineField("info");
        $getHandler->DefineField("period_month");
        $getHandler->DefineField("period_id");
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
             $getHandler->CreateNewRecord($row['period_id']);
             $getHandler->DefineRecordFieldValue("period_year", $row['period_year']);
             $getHandler->DefineRecordFieldValue("period_name",$row['period_name']);
             $getHandler->DefineRecordFieldValue("isactive", $row['isactive']);
             $getHandler->DefineRecordFieldValue("seqno", $row['seqno']);
             $getHandler->DefineRecordFieldValue("info","recordinfo.php?id=".$row['period_id']."&tablename=sim_period&idname=period_id&title=Period");
             $getHandler->DefineRecordFieldValue("period_month",$row['period_month']);
             $getHandler->DefineRecordFieldValue("period_id",$row['period_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showPeriod()");
    }

 public function savePeriod(){
    $this->log->showLog(2,"Access savePeriod");
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
       $tablename="sim_period";

        $save = new Save_Data();
        $insertCount = $saveHandler->ReturnInsertCount();
        $this->log->showLog(3,"Start Insert($insertCount records)");

if ($insertCount > 0)
{
    $arrfield=array("period_year", "period_name","isactive","seqno",
                    "created","createdby","updated","updatedby","period_month");
    $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s','%d','%s');

// Yes there are INSERTs to perform...
 for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
 {

     $arrvalue=array($saveHandler->ReturnInsertField($currentRecord, "period_year"),
                $saveHandler->ReturnInsertField($currentRecord, "period_name"),
                $saveHandler->ReturnInsertField($currentRecord,"isactive"),
                $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $timestamp,
                $createdby,
                $saveHandler->ReturnInsertField($currentRecord,"period_month")
         );
     $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "period_year");
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"period_id");
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

      $arrfield=array("period_year", "period_name", "isactive","seqno",
           "updated","updatedby","period_month");
      $arrfieldtype=array('%s','%s','%d','%d','%s','%d','%s');
 // Yes there are UPDATEs to perform...

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
         $this->log->showLog(3,"***updating record($currentRecord),new period_name:".
                $saveHandler->ReturnUpdateField($currentRecord, "period_name").",id:".
                $saveHandler->ReturnUpdateField($currentRecord)."\n");
                $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "period_year");

 }

 for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
 {

        $arrvalue=array($saveHandler->ReturnUpdateField($currentRecord, "period_year"),
                $saveHandler->ReturnUpdateField($currentRecord, "period_name"),
                $saveHandler->ReturnUpdateField($currentRecord,"isactive"),
                $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                $timestamp,
                $createdby,
                $saveHandler->ReturnUpdateField($currentRecord,"period_month"),
                );
        $this->log->showLog(3,"***updating record($currentRecord),new period_name:".
              $saveHandler->ReturnUpdateField($currentRecord, "period_name").",id:".
              $saveHandler->ReturnUpdateField($currentRecord,"period_id")."\n");

         $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "period_year");

         $save->UpdateRecord($tablename, "period_id", $saveHandler->ReturnUpdateField($currentRecord,"period_id"),
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
//include "class/Period.inc.php";
//$o = new Period();

if ($deleteCount > 0){
  for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
    $record_id=$saveHandler->ReturnDeleteField($currentRecord);

    $this->fetchPeriod($record_id);
    $controlvalue=$this->period_year;
    $isdeleted=$this->isdeleted;

    $save->DeleteRecord("sim_period","period_id",$record_id,$controlvalue,1);

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

public function showLookupPeriod(){
        $this->log->showLog(2,"Run lookup showPeriod()");
        $tablename="sim_period";
    global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;
    if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="period_year";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
      $sql = "SELECT  period_id, period_year, period_name, isactive,seqno
            FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
    $this->log->showLog(4," with SQL: $sql");
        $query = $this->xoopsDB->query($sql);

	$currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["period_id"]);
                       $getHandler->DefineRecordFieldValue("period_id", $row["period_id"]);
                       $getHandler->DefineRecordFieldValue("period_name", $row["period_name"]);
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

         }

    }
$getHandler->completeGet();
    }

public function getPeriodArray($periodfrom_id,$periodto_id){
      global $tableperiod;
           $this->fetchPeriod($periodfrom_id);
          $periodfrom=$this->period_name;

           $this->fetchPeriod($periodto_id);
          $periodto=$this->period_name;

        $sql="SELECT period_id,period_name from $tableperiod
                where period_name between '$periodfrom' and '$periodto' order by period_name ASC";
          $query=$this->xoopsDB->query($sql);
          $data=array();
          while($row=$this->xoopsDB->fetchArray($query))
          $data[]=$row['period_id'];
	return $data;
       }

public function getPeriodID($year,$month){
        $sql="SELECT period_id from $this->tableperiod
                where period_year =$year and period_month=$month order by period_name ASC";
          $query=$this->xoopsDB->query($sql);
          $data=array();
          while($row=$this->xoopsDB->fetchArray($query))
          return $row['period_id'];
	return 0;
       }
       
public function generatePeriod(){
        $this->log->showLog(2,"Access generatePeriod");
        include_once "../simantz/class/Save_Data.inc.php";
        global $xoopsDB,$xoopsUser,$selectspliter;

        $timestamp=date("Y-m-d H:i:s",time());
        $createdby=$xoopsUser->getVar('uid');
        $uname=$xoopsUser->getVar('uname');
        $organization_id=$this->defaultorganization_id;
        $tablename="sim_period";
        $save = new Save_Data();

    $arrfield=array("period_name","period_year","period_month","isactive","seqno",
                    "created","createdby","updated","updatedby");

    $arrfieldtype=array('%s','%d','%d','%d','%d',
                        '%s','%d','%s','%d');
 $period_month=1;
// Yes there are INSERTs to perform...
 while ($period_month<13){
     
     if($period_month<10)
        $period_month="0".$period_month;

     $period_name=$this->generateYear."-".$period_month;
     $arrvalue=array($period_name,$this->generateYear,$period_month,1,10,
                     $timestamp,$createdby,$timestamp,$createdby);
     
     $controlvalue=$period_name;
     $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"period_id");
     
//  if($save->failfeedback!=""){
//      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
//      $this->failfeedback.=$save->failfeedback;
//  }
  $period_month++;
  // Now we execute this query
 }

}

} // end of ClassJobposition
?>

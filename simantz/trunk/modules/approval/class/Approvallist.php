<?php


class Approvallist
{

  public $leave_id;
  public $leave_name;
  public $leave_no;
  public $leave_category;

  public $department_id;
  public $semester_id;
  public $leavetype_id;

  public $organization_id;
  public $defaultlevel;

  public $orgctrl;
  public $accounclassctrl;
  private $xoopsDB;
  private $tableprefix;
  private $tableleave;
  private $tablebpartner;

  private $log;


//constructor
   public function Approvallist(){
    global $xoopsDB,$log,$tableleave,$tableorganization;


    $this->xoopsDB=$xoopsDB;
    $this->tableorganization=$tableorganization;
    $this->tableleave=$tableleave;

    $this->log=$log;

   }



  /*
   * Show search form
   */

  public function showSearchForm(){
    global $nitobigridthemes,$isadmin,$havewriteperm;

    $rowsperpage = "10";

    if($isadmin==1){
    $grIdColumn=7; //define primary key column index, it will set as readonly afterwards (count from 0)
        $deleteddefaultvalue_js="myGrid.getCellObject(rowNo,6).setValue(0);"; //if admin login got deleted column, during admin insert new record shall set it default =0 (not deleted)
    }
    else{
        $grIdColumn=5;//define primary key column index for normal user
        $deleteddefaultvalue_js="";
    }

    $savectrl="";
    $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
    $alloweditgrid= "false";

echo <<< EOF

<script language="javascript" type="text/javascript">

    jQuery(document).ready((function (){nitobi.loadComponent('DataboundGridApprovalList');}));

    function init(){}

     function search(){

        var grid = nitobi.getGrid("DataboundGridApprovalList");
        var searchemployee_no=document.getElementById("searchemployee_no").value;
        var searchemployee_name=document.getElementById("searchemployee_name").value;
        var searchleave_fromdate=document.getElementById("searchleave_fromdate").value;
        var searchleave_todate=document.getElementById("searchleave_todate").value;
        //var searchleave_no=document.getElementById("searchleave_no").value;
        var searchiscomplete=document.getElementById("searchiscomplete").checked;
        var searchishistory=document.getElementById("searchishistory").checked;

        var searchTxt = "";
        if(searchiscomplete == true)
        searchiscompletetxt = "Yes";
        else
        searchiscompletetxt = "No";

        if(searchishistory == true)
        searchishistorytxt = "Yes";
        else
        searchishistorytxt = "No";

        if(searchemployee_no != "")
        searchTxt += "Employee No : "+searchemployee_no+"<br/>";
        if(searchemployee_name != "")
        searchTxt += "Employee Name : "+searchemployee_name+"<br/>";
        if(searchleave_fromdate != "")
        searchTxt += "Date From : "+searchleave_fromdate+"<br/>";
        if(searchleave_todate != "")
        searchTxt += "Date To : "+searchleave_todate+"<br/>";
        //if(searchleave_no != "")
        //searchTxt += "Doc No : "+searchleave_no+"<br/>";

        searchTxt += "Complete : "+searchiscompletetxt+"<br/>";
        //searchTxt += "Approval History : "+searchishistorytxt+"<br/>";

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        //if(document.getElementById("searchisdeleted"))
        //var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchemployee_no',searchemployee_no);
	grid.getDataSource().setGetHandlerParameter('searchemployee_name',searchemployee_name);
	grid.getDataSource().setGetHandlerParameter('searchleave_fromdate',searchleave_fromdate);
        grid.getDataSource().setGetHandlerParameter('searchleave_todate',searchleave_todate);
        //grid.getDataSource().setGetHandlerParameter('searchleave_no',searchleave_no);
        grid.getDataSource().setGetHandlerParameter('searchiscomplete',searchiscomplete);
        grid.getDataSource().setGetHandlerParameter('searchishistory',searchishistory);

        document.getElementById('rightBox').innerHTML = searchTxt;
        //reload grid data
	grid.dataBind();
        //Pager.First('DataboundGridApprovalList');
    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
//		var myAjaxRequest = new nitobi.ajax.HttpRequest();
//
//		// Define the url for your generatekey script
//		//myAjaxRequest.handler = 'approvallist.php?rnd=' + Math.random();
//                myAjaxRequest.handler = 'approvallist.php?action=searchgrid&';
//		myAjaxRequest.async = false;
//		myAjaxRequest.get();
//
//		// return the result to the grid
//		return myAjaxRequest.httpObj.responseText;
    }

    //after grid html render properly, set focus on it. It is important when use choose particular cell but
    // immediately press search again. From screen we won't detect cell is selected infact from javascript
    // detect selected
   function dataready(){

       var  g = nitobi.getGrid('DataboundGridApprovalList');
        g.move(0,0);//need to trigger relative position 0,0 in for next code able to highlight at screen
        var selRow = g.getSelectedRow();

    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('DataboundGridApprovalList');
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

        var grid= nitobi.getGrid('DataboundGridApprovalList');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();



        if (errorMessage) {
             document.getElementById('msgbox').innerHTML="<b style=\"color:red\">"+errorMessage+"</b><br/>";
             //grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    
                    var  myGrid = nitobi.getGrid('DataboundGridApprovalList');
                    var myCell = myGrid.getCellObject(row, col);
                    var objectVal = myGrid.getCellObject(row, 11);
                    var objectVal2 = myGrid.getCellObject(row, 10);
                    var objectVal3 = myGrid.getCellObject(row, 9);
                    var objectVal4 = myGrid.getCellObject(row, 12);
                    var objectVal5 = myGrid.getCellObject(row, 8);
                    var objectVal6 = myGrid.getCellObject(row, 13);

                    var primarykey_value = objectVal.getValue();
                    var primarykey_name = objectVal2.getValue();
                    var tablename = objectVal3.getValue();
                    var window_workflow = objectVal4.getValue();
                    var workflowtransaction_id = objectVal5.getValue();
                    var hyperlink = objectVal6.getValue();
	
                    if(col == 6){
//                        if(primarykey_name == "leave_id"){
//                        window.open("leave.php?action=edit&leave_id="+primarykey_value,"Leave"+primarykey_value);
//                        }

                            //if(primarykey_name == "leave_id"){
                            //window.open("leave.php?action=edit&leave_id="+primarykey_value,"Leave"+primarykey_value);
                            window.open(hyperlink+"?action=edit&"+primarykey_name+"="+primarykey_value,window_workflow+"-"+primarykey_value);
                            //}
                            search();
                    }

                    if(col == 7){
                    //alert(workflowtransaction_id);
                        //if(primarykey_name == "leave_id"){
                            var data="action=approvalwindows&primarykey_value="+primarykey_value+"&primarykey_name="+primarykey_name+"&tablename="+tablename+"&window_workflow="+window_workflow+"&workflowtransaction_id="+workflowtransaction_id;

                            $.ajax({
                            url: "approvallist.php",type: "GET",data: data,cache: false,
                            success: function (xml) {

                            document.getElementById('idApprovalWindows').innerHTML = xml;
                            document.getElementById('idApprovalWindows').style.display = "";
                            search();
                            }

                        });

                        //}
                    }



    }

    //add line button will call this
    function addline(){
    var g= nitobi.getGrid('DataboundGridApprovalList');
        g.insertAfterCurrentRow();
    }

    //trigger save activity from javascript
   function save()
     {
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DataboundGridApprovalList');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(confirm("Confirm the changes? Data will save into database immediately")){
          //popup('popUpDiv');
     	  var g= nitobi.getGrid('DataboundGridApprovalList');
	    document.getElementById("afterconfirm").value=0;
	    g.save();
	    search();
    	   }
    	  // else //cancel request
	    //search();
	}
    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation
   	var g= nitobi.getGrid('DataboundGridApprovalList');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
    }

    function checkAllowEdit(eventArgs){
	var g= nitobi.getGrid('DataboundGridApprovalList');
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
   myGrid.getCellObject(rowNo,3).setValue(10);
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

    function closeWorkflowWindow(){
    document.getElementById('idApprovalWindows').style.display = "none";
    }

</script>
   <div id="idApprovalWindows" style="display:none"></div>
   <table style="width:950px;"><tr><td>$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr></table>

    <div >
    <table style="width:950px;" align="center">

    <tr><td align="center" class="searchformheader">Search Form</td></tr>

    <tr>
    <td>
EOF;
        $this->headerSearchForm();
echo <<< EOF
    </td>
    </tr>

    <tr>
    <td>
    <div align="center" id="statusDiv"></div>
    <div align="center">
    <input type="hidden" id="totalRowGrid" value="$rowsperpage">
    <table style="width:950px;"><tr><td class="head tdPager">
    $savectrl

    <div id="pager_control" class="inline">
    <div id="pager_first" class="inline FirstPage" onclick="Pager.First('DataboundGridApprovalList');" onmouseover="this.className+=' FirstPageHover';" onmouseout="this.className='inline FirstPage';" style="margin:0;border-right:1px solid #B1BAC2;"></div>
    <div id="pager_prev" class="inline PreviousPage" onclick="Pager.Previous('DataboundGridApprovalList');" onmouseover="this.className+=' PreviousPageHover';" onmouseout="this.className='inline PreviousPage';" style="margin:0;"></div>
    <div class="inline" style="height:22px;top:3px;">
        <span class="inline">Page</span>
        <span class="inline" id="pager_current">0</span>
        <span class="inline">of</span>
        <span class="inline" id="pager_total">0</span>
    </div>
    <div id="pager_next" class="inline NextPage" onclick="Pager.Next('DataboundGridApprovalList');" onmouseover="this.className+=' NextPageHover';" onmouseout="this.className='inline NextPage';" style="margin:0;border-right:1px solid #B1BAC2;"></div>
    <div id="pager_last" class="inline LastPage" onclick="Pager.Last('DataboundGridApprovalList');" onmouseover="this.className+=' LastPageHover';" onmouseout="this.className='inline LastPage';" style="margin:0;"></div>
    </div>
    </td></tr></table>
    </td>
    </tr>

        <!--     savehandler="approvallist.php?action=save"  -->
    <tr>
        <td align="center">

        <ntb:grid id="DataboundGridApprovalList"
             mode="standard"
             toolbarenabled='false'
             $permctrl
             ondatareadyevent="HandleReady(eventArgs);"
             onhandlererrorevent="showError()"
             oncellclickevent="clickrecord(eventArgs)"
             keygenerator="GetNewRecordID();"

             gethandler="approvallist.php?action=searchgrid"

             onbeforecelleditevent="checkAllowEdit(eventArgs)"
             onafterrowinsertevent="setDefaultValue(eventArgs)"
             rowhighlightenabled="true"
             width="943"
             height="380"
             rowheight="70"
             onaftersaveevent="savedone(eventArgs)"
             onbeforerowdeleteevent="beforeDelete()"
             onafterrowdeleteevent="save()"
             autosaveenabled="false"
             theme="$nitobigridthemes"
             rowsperpage="$rowsperpage"
             >

            <ntb:columns>
            <ntb:textcolumn width="30" label="No." xdatafld="seq_no" classname="{\$rh}"></ntb:textcolumn>
            <ntb:textcolumn width="150" label="Description" xdatafld="workflow_name" classname="{\$rh}"></ntb:textcolumn>
            <ntb:textcolumn width="130" label="Employee" xdatafld="employee_name" classname="{\$rh}"></ntb:textcolumn>
            <ntb:textcolumn width="115" label="Date" xdatafld="apply_date" classname="{\$rh}"></ntb:textcolumn>
            <ntb:textcolumn width="350" label="Detail" xdatafld="workflowtransaction_description" classname="{\$rh}"></ntb:textcolumn>
            <ntb:textcolumn width="65" label="Status" xdatafld="workflowstatus_name" classname="{\$rh}"></ntb:textcolumn>
            <ntb:textcolumn label="Edit" xdatafld="operation" sortenabled="false" width="35" initial="images/del.gif" classname="{\$rh}" align="center" cssstyle="cursor:pointer;">
            <ntb:imageeditor></ntb:imageeditor>
            </ntb:textcolumn>
            <ntb:textcolumn label="Action" xdatafld="approval" sortenabled="false" width="45" initial="images/approval.gif" classname="{\$rh}" align="center" cssstyle="cursor:pointer;">
            <ntb:imageeditor></ntb:imageeditor>
            </ntb:textcolumn>

           <ntb:textcolumn   label=""  width="0" xdatafld="workflowtransaction_id" sortenabled="false"></ntb:textcolumn>
           <ntb:textcolumn   label=""  width="0" xdatafld="tablename" sortenabled="false"></ntb:textcolumn>
           <ntb:textcolumn   label=""  width="0" xdatafld="primarykey_name" sortenabled="false"></ntb:textcolumn>
           <ntb:textcolumn   label=""  width="0" xdatafld="primarykey_value" sortenabled="false"></ntb:textcolumn>
           <ntb:textcolumn   label=""  width="0" xdatafld="window_workflow" sortenabled="false"></ntb:textcolumn>
           <ntb:textcolumn   label=""  width="0" xdatafld="hyperlink" sortenabled="false"></ntb:textcolumn>

</ntb:columns>
         </ntb:grid>

        </td>
    </tr>

    <tr>
    <td><div id="msgbox" style='display:none'></div></td>
    </tr>

   </table>
   </div>
EOF;
  }

  /*
   * header search form
   */
  public function headerSearchForm(){
        global $dp;

        $this->searchleave_fromdatectrl=$dp->show("searchleave_fromdate");
        $this->searchleave_todatectrl=$dp->show("searchleave_todate");

        $stylesearchemployee = "style='display:none'";
        if($this->isAdmin)
        $stylesearchemployee = "";

echo <<< EOF
    <table >
        <tr height="100px">
            <td width="70%" class="headerSearchTdTable">
                <table>

                <tr $stylesearchemployee >
                <td class="searchTitle">Employee No.</td><td><input name="searchemployee_no" id="searchemployee_no"></td>
                <td class="searchTitle">Employee Name</td><td><input name="searchemployee_name" id="searchemployee_name"></td>
                </tr>

                <tr>
                <td class="head">Date From</td>
                  <td class="even">
                    <input name='searchleave_fromdate' id='searchleave_fromdate' value="$this->searchleave_fromdate" maxlength='10' size='12'>
                    <input name='btnDate' value="Date" type="button" onclick="$this->searchleave_fromdatectrl">
                  </td>
                <td class="head">Date To</td>
                  <td class="even">
                    <input name='searchleave_fromto' id='searchleave_todate' value="$this->searchleave_todate" maxlength='10' size='12'>
                    <input name='btnDate' value="Date" type="button" onclick="$this->searchleave_todatectrl">
                  </td>
                </tr>

                <tr>
                <!--<td class="head">Doc No.</td><td class="even"><input name="searchleave_no" id="searchleave_no"></td>-->
                <td class="head">Complete</td>
                  <td colspan="3"><input type="checkbox" name="searchiscomplete" id="searchiscomplete"></td>
                <td class="even" style="display:none">Approval History</td><td style="display:none"><input type="checkbox" name="searchishistory" id="searchishistory"></td>
                </tr>

                <tr>
                <td colspan="2" align="left" class="head"><input type="button" value="Search" onclick="search()"></td>
                <td colspan="2"></td>
                </tr>

                </table>
            </td>

            <td width="30%" class="headerSearchTdTable">
            <div id="totalRecord"></div>
            <div id="rightBox"></div>
            </td>
        </tr>
    </table>
EOF;

  }



  /**
   * Pull data from leave table into class
   *
   * @return bool
   * @access public
   */
  public function fetchApprovallist( $leave_id) {


	$this->log->showLog(3,"Fetching leave detail into class Approvallist.php.<br>");

	$sql= sprintf("SELECT * from sim_hr_leave where leave_id='%d'",$leave_id);

	$this->log->showLog(4,"ProductApprovallist->fetchApprovallist, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
        $this->leave_date=$row["leave_date"];
        $this->leave_no=$row["leave_no"];
        $this->organization_id=$row['organization_id'];
        $this->employee_id= $row['employee_id'];
        $this->leave_day= $row['leave_day'];
        $this->time_from= $row['time_from'];
        $this->time_to= $row['time_to'];
        $this->total_hours= $row['total_hours'];

        $this->iscomplete=$row['iscomplete'];
        $this->description=$row['description'];
        $this->issubmit=$row['issubmit'];

        $this->leave_fromdate=$row['leave_fromdate'];
        $this->leave_todate=$row['leave_todate'];
        $this->leave_address=$row['leave_address'];
        $this->leave_telno=$row['leave_telno'];
        $this->leavetype_id=$row['leavetype_id'];
        $this->lecturer_remarks=$row['lecturer_remarks'];

        $this->panelclinic_id=$row['panelclinic_id'];
        $this->table_type=$row['table_type'];

   	$this->log->showLog(4,"Approvallist->fetchApprovallist,database fetch into class successfully");
	$this->log->showLog(4,"leave_name:$this->leave_name");

	$this->log->showLog(4,"isactive:$this->isactive");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Approvallist->fetchApprovallist,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchApprovallist


  public function getIncludeFileMenu(){
      global $xoTheme;


    $xoTheme->addScript("$url/modules/simantz/include/validatetext.js");
    $xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
    $xoTheme->addScript("$url/modules/simantz/include/popup.js");
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.toolkit.js");

    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/paginator.js");
    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/paginator.css");

    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css");
    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.tabstrip/nitobi.tabstrip.css");
    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.css");
    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js");
    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.tabstrip/nitobi.tabstrip.js");
    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.js");

    $xoTheme->addScript("$url/modules/simantz/include/firefox3_6fix.js");
  }


  /*
   * define parameter for workflow in array
   */

  public function defineWorkflowParameter(){

//        /* start define hod */
//        include_once "../hr/class/Employee.php";
//        $emp = new Employee();
//

    switch ($this->window_workflow){

     CASE  "LEAVE":
        include_once "../hr/class/Leave.php";
        $lev = new Leave();
               $lev->leave_id=$this->primarykey_value;
               $lev->person_id=$this->person_id;
               $lev->window_workflow= $this->window_workflow;
        return $lev->defineWorkflowParameter();
     break;

     CASE  "GENERCLAIM":

        include_once "../hr/class/Generalclaim.php";
        $gen = new Generalclaim();
               $gen->generalclaim_id=$this->primarykey_value;
               $gen->person_id=$this->person_id;
               $gen->window_workflow= $this->window_workflow;
        return $gen->defineWorkflowParameter();
     break;

     CASE  "MEDICCLAIM":

        include_once "../hr/class/Medicalclaim.php";
        $me = new Medicalclaim();
               $me->medicalclaim_id=$this->primarykey_value;
               $me->person_id=$this->person_id;
               $me->window_workflow= $this->window_workflow;
        return $me->defineWorkflowParameter();
     break;

      CASE  "OVERCLAIM":

        include_once "../hr/class/Overtimeclaim.php";
        $ov = new Overtimeclaim();
               $ov->overtimeclaim_id=$this->primarykey_value;
               $ov->person_id=$this->person_id;
               $ov->window_workflow= $this->window_workflow;
        return $ov->defineWorkflowParameter();
     break;

      CASE  "TRAVECLAIM":

        include_once "../hr/class/Travellingclaim.php";
        $tr = new Travellingclaim();
               $tr->travellingclaim_id=$this->primarykey_value;
               $tr->person_id=$this->person_id;
               $tr->window_workflow= $this->window_workflow;
        return $tr->defineWorkflowParameter();
     break;
 
      CASE  "LEAVEADJ":

        include_once "../hr/class/Leaveadjustment.php";
        $led = new Leaveadjustment();
               $led->leaveadjustment_id=$this->primarykey_value;
               $led->person_id=$this->person_id;
               $led->window_workflow= $this->window_workflow;
        return $led->defineWorkflowParameter();
     break;

     default:
         break;
    }

  }

  /*
   * define header button
   */

  public function defineHeaderButton(){
    $this->addnewctrl='';
    $this->searchctrl='';
  }

  /*
   * get employee_id from uid
   */
  public function getEmployeeId($uid=0){

    $retval = 0;
    $sql = sprintf("SELECT employee_id FROM sim_hr_employee WHERE uid = '%d' ",$uid);

    $rs=$this->xoopsDB->query($sql);

    if($row=$this->xoopsDB->fetchArray($rs)){
    $retval = $row['employee_id'];
    }

    return $retval;

  }

    /*
     * define style display none for tr leave
     */

    public function defineStyleTRApprovallist($leave_fromdate,$leave_todate,$leave_fromdate){

        $styleidTotalDay = "style='display:none'";
        $styleidTimeApprovallist = "style='display:none'";
        $styleidTotalHours = "style='display:none'";

        if($leave_fromdate == $leave_todate && $leave_fromdate != ""){//if stay away (time off)
        $styleidTimeApprovallist = "";
        $styleidTotalHours = "";
        }

        if($leave_fromdate != $leave_todate || $leave_fromdate == ""){//if not stay away (time off)
        $styleidTotalDay = "";
        }

        return array("styleidTotalDay"=>$styleidTotalDay,"styleidTimeApprovallist"=>$styleidTimeApprovallist,"styleidTotalHours"=>$styleidTotalHours);
    }


    /*
     * show approval windows
     */
    public function approvalwindows($primarykey_value,$primarykey_name,$tablename,$window_workflow,$workflowtransaction_id){
        global $workflowapi;

        /*
        $sql = sprintf("SELECT wf.*, em.employee_name, em.employee_no, '%s' as window_workflow
                        FROM %s wf
                        INNER JOIN sim_hr_employee em ON wf.employee_id = em.employee_id
                        WHERE %s = %d ",$window_workflow,$tablename,$primarykey_name,$primarykey_value);
         *
         */


        $sql = sprintf("SELECT *
                        FROM sim_workflowtransaction wt
                        LEFT JOIN sim_hr_employee emp ON wt.person_id = emp.employee_id
                        INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id
                        WHERE wt.workflowtransaction_id = $workflowtransaction_id ");

        //$this->log->showLog(4,"approvalwindows SQL: $sql");
        $query = $this->xoopsDB->query($sql);
        $person_id = 0;
        while ($row=$this->xoopsDB->fetchArray($query))
        {
            $employee_name = $row['employee_name'];
            $employee_no = $row['employee_no'];
            $person_id = $row['person_id'];
            $workflow_code  = $row['workflow_code'];
            $workflow_name = $row['workflow_name'];
            $primarykey_value = $row['primarykey_value'];
            $primarykey_name = $row['primarykey_name'];
            $tablename = $row['tablename'];
            $hyperlink = $row['hyperlink'];
            $this->window_workflow = $workflow_code;

            $sqldetails = sprintf("SELECT * FROM sim_workflowtransaction WHERE workflowtransaction_id = %d ",$workflowtransaction_id);

            $querydetails = $this->xoopsDB->query($sqldetails);

            if ($rowdetails=$this->xoopsDB->fetchArray($querydetails)){
                $workflowtransaction_description = $rowdetails['workflowtransaction_description'];
            }
        }
        $this->parameter_array = $this->defineWorkflowParameter();
        $workflowtransaction_description = str_replace("\n","<br>",$workflowtransaction_description);
        $viewdetails = "$hyperlink?action=edit&$primarykey_name=$primarykey_value";

//        foreach($this->parameter_array as $id){
//           $this->log->showLog(4," parameter_array SQL: $sql");
//        }
        $workflowbtn = $workflowapi->getWorkflowButton($workflow_code,$primarykey_value,"idLeaveForm","action",$this->parameter_array,"ajax",$person_id);
        $workflow_history = $workflowapi->showWorkflowHistory($workflow_code,$primarykey_value);//show workflow history in html

echo <<< EOF
           <div class="dimBackground"></div>


     <form method="post" id="idLeaveForm" action="approvallist.php" name="frmLeave" >
    <input type="hidden" id="action" name="action" value="next_node"> 
    <input type="hidden" id="primarykey_value" name="primarykey_value" value="$primarykey_value">
    <input type="hidden" id="primarykey_name" name="primarykey_name" value="$primarykey_name">
    <input type="hidden" id="tablename" name="tablename" value="$tablename">
    <input type="hidden" id="window_workflow" name="window_workflow" value="$workflow_code">

   <table>
    <tr>
    <td astyle="vertical-align:middle;" align="center">
        <p>
        <table class="floatWindow">
            <tr>

            <tr>
            <td class="searchformheader" align="center" colspan="2"> Approval </td>
            </tr>
            <tr>
            <td><a href="$viewdetails" target="_blank" title="View Details">View Details <img src="images/zoom.png"></a></td>
            <td align="right" style="vertical-align:top;" >
            <img src="images/close.png" onclick="closeWorkflowWindow();" style="cursor:pointer" title="Close">
            </td>
            </tr>

            <tr >
            <td align="left" width="35%">
            <table style="width:350px" class="approvalInfo">
            <tr>
            <td class='searchTitle' width="20%">Name </td><td width="80%"> : <a target='_blank' href='../hr/employee.php?action=tablist&mode=view&employee_id=$person_id'>$employee_name</a></td>
            </tr>
            <tr>
            <td class='searchTitle'>Staff No </td><td> : $employee_no</td>
            </tr>
            <tr>
            <td class='searchTitle'>Details </td><td> : $workflowtransaction_description - </td>
            </tr>
            </table>
            </td>
            <td width="65%" style="vertical-align:bottom">
            $workflowbtn
            </td>
            </tr>

            <tr>
            <td align="left" style="vertical-align:top;" colspan='2'>

            $workflow_history</td>
            </tr>

        </table>
        </p>
    </td>
    </tr>
   </table>

   </form>

EOF;
    }


/*
   * nitobi leave grid
   */
    public function showApprovallistGrid($wherestring){
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    include_once "../simantz/class/EBAGetHandler.php";
    $getHandler = new EBAGetHandler();


    //var_dump($_GET['StartRecord']) ;
    $this->log->showLog(3,"Load showApprovallistGrid with Query String=".$_SERVER['QUERY_STRING']);

        $pageSize=10;
        if (isset($_GET['PageSize'])) {
                $pageSize = $_GET['PageSize'];
                if(empty($pageSize)){
                        $pageSize=10;
                }
        }
        $ordinalStart=0;
        if (isset($_GET['StartRecord'])) {
                $ordinalStart = $_GET['StartRecord'];
                if(empty($ordinalStart)){
                        $ordinalStart=0;
                }
        }


        $sortcolumn=$_GET["SortColumn"];
        //$sortdirection=$_GET["SortDirection"];



    $tablename="sim_hr_leave";

    $searchemployee_no=$_GET['searchemployee_no'];
    $searchemployee_name=$_GET['searchemployee_name'];
    $searchleave_fromdate=$_GET['searchleave_fromdate'];
    $searchleave_todate=$_GET['searchleave_todate'];
    //$searchleave_no=$_GET['searchleave_no'];
    $searchiscomplete=$_GET['searchiscomplete'];
    $searchishistory=$_GET['searchishistory'];

    $this->log->showLog(2,"Access ShowApprovallisttype($wherestring)");


        /*
        if(empty($sortcolumn)){
           $sortcolumn="wt.created";
        }
        if(empty($sortdirection)){
           $sortdirection="DESC";
        }


        $wherestring2 = " WHERE 1 ";

        if($searchiscomplete != "true"){
        $wherestring .= " AND lv.iscomplete = '0' ";
        }else{
        $wherestring .= " AND lv.iscomplete = '1' ";
        }

        if($searchemployee_no != ""){
        $wherestring .= " AND em.employee_no LIKE '$searchemployee_no' ";
        $whereArray[]=$searchemployee_no;
        }
        if($searchemployee_name != ""){
        $wherestring .= " AND em.employee_name LIKE '$searchemployee_name' ";
        $whereArray[]=$searchemployee_name;
        }

        if($searchleave_fromdate != "" && $searchleave_todate != ""){
        $wherestring2 .= " AND a.apply_date BETWEEN '$searchleave_fromdate' AND '$searchleave_todate' ";
        }

        if($searchleave_no != ""){
        $wherestring2 .= " AND a.doc_no LIKE '%$searchleave_no' ";
        }

        $wherestring .= " AND (wt.target_uid = $this->createdby OR $this->createdby IN (wt.targetparameter_name)
                        OR $this->createdby IN (SELECT uid FROM sim_groups_users_link WHERE groupid = wt.target_groupid)
                        ) ";
         *
         */


        if($searchemployee_no != ""){
        $wherestrapp .= " AND employee_no LIKE '%$searchemployee_no%' ";

        }
        if($searchemployee_name != ""){
        $wherestrapp .= " AND employee_name LIKE '%$searchemployee_name%' ";
  
        }

       if($searchemployee_name != "" || $searchemployee_no != "")
        {
            $sql="select employee_id from sim_hr_employee where employee_id>0 $wherestrapp";
            $this->log->showLog(4,"Fetchappraisal With SQL: $sql");
            $query=$xoopsDB->query($sql);
            $i=0;
            $arremployee_id="";
            while ($row=$xoopsDB->fetchArray($query))
            {
              $i++;
              $employee_id=$row['employee_id'];
              $arremployee_id .= ",'$employee_id'";

             }
          $arremployee_id = substr($arremployee_id,1);
          $wherestring .= " and emp.employee_id in ($arremployee_id) ";

         }


        if($searchleave_fromdate != "" && $searchleave_todate != ""){
        $wherestring .= " AND wt.workflowtransaction_datetime BETWEEN '$searchleave_fromdate' AND '$searchleave_todate' ";
        }

        $wherestring .= " AND (wt.target_uid = $this->createdby OR wt.targetparameter_name LIKE concat('%[',$this->createdby,']%') ".
                      "  OR $this->createdby IN (SELECT uid FROM sim_groups_users_link WHERE groupid = wt.target_groupid)) ";

//        $wherestring .= " AND wt.iscomplete = 0 ";
        if($searchiscomplete != "true"){
        $wherestring .= " AND wt.iscomplete = '0' ";
        }else{
        $wherestring .= " AND wt.iscomplete = '1' ";
        }


        $sql = "SELECT wt.*, emp.employee_name, emp.employee_no, emp.employee_id,".
                " wf.workflow_name,ws.workflowstatus_name,wt.workflowtransaction_description ".
                " FROM sim_workflowtransaction wt ".
                " LEFT JOIN sim_hr_employee emp ON wt.person_id = emp.employee_id ".
                " INNER JOIN sim_workflow wf ON wt.workflow_id = wf.workflow_id ".
                " INNER JOIN sim_workflowstatus ws ON wt.workflowstatus_id = ws.workflowstatus_id ".
                " $wherestring  ORDER BY wt.created DESC";

                // GROUP BY wt.tablename, wt.primarykey_name, wt.primarykey_value
                //ORDER BY " . $sortcolumn . " " . $sortdirection ." ";

        $this->log->showLog(4,"showApprovallistGrid SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("seq_no");
        $getHandler->DefineField("workflow_name");
        $getHandler->DefineField("workflowstatus_name");
        $getHandler->DefineField("tablename");
        $getHandler->DefineField("primarykey_name");
        $getHandler->DefineField("primarykey_value");
        $getHandler->DefineField("window_workflow");
        $getHandler->DefineField("workflow_name");
        $getHandler->DefineField("employee_name");
        $getHandler->DefineField("apply_date");
        $getHandler->DefineField("doc_no");
        $getHandler->DefineField("person_id");
        $getHandler->DefineField("hyperlink");
        $getHandler->DefineField("workflowstatus_name");
        $getHandler->DefineField("workflowtransaction_description");
        //$getHandler->DefineField("completeleave");
        $getHandler->DefineField("rh");

	$currentRecord = 0; // This will assist us finding the ordinalStart position
        $i=0;
      while ($row=$xoopsDB->fetchArray($query))
     {

            $issubmit = $row['issubmit'];

            if($searchiscomplete == "true")
            $issubmit = 1;



            if($issubmit == 1){
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){

            if($rh=="even")
            $rh="odd";
            else
            $rh="even";

             $i++;
             $getHandler->CreateNewRecord($row['workflowtransaction_id']);

             $getHandler->DefineRecordFieldValue("seq_no", $currentRecord);
             $getHandler->DefineRecordFieldValue("workflow_name", $row['workflow_name']);
             $getHandler->DefineRecordFieldValue("tablename", $row['tablename']);
             $getHandler->DefineRecordFieldValue("primarykey_name", $row['primarykey_name']);
             $getHandler->DefineRecordFieldValue("primarykey_value", $row['primarykey_value']);
             $getHandler->DefineRecordFieldValue("window_workflow", $row['window_workflow']);
             $getHandler->DefineRecordFieldValue("workflowstatus_name", $row['workflowstatus_name']);//$this->getWorkflowTransactionStatus($row['workflowtransaction_id'])
             $getHandler->DefineRecordFieldValue("employee_name", $row['employee_name']." - ".$row['employee_no']);
             $getHandler->DefineRecordFieldValue("apply_date", $row['created']);
             $getHandler->DefineRecordFieldValue("doc_no", $row['doc_no']);
             $getHandler->DefineRecordFieldValue("person_id", $row['person_id']);
             $getHandler->DefineRecordFieldValue("hyperlink", $row['hyperlink']);
             $getHandler->DefineRecordFieldValue("workflowstatus_name", $row['workflowstatus_name']);
             $getHandler->DefineRecordFieldValue("workflowtransaction_description", $row['workflowtransaction_description']);


             //$getHandler->DefineRecordFieldValue("iscomplete",($row['completeleave'] == 1 ? "Yes" : "No"));

             $getHandler->DefineRecordFieldValue("operation", "images/docicon.gif");
             $getHandler->DefineRecordFieldValue("approval",	 "images/approval.gif");
             $getHandler->DefineRecordFieldValue("workflowtransaction_id",$row['workflowtransaction_id']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }

            }
      }

        $getHandler->setErrorMessage($currentRecord);
        $getHandler->CompleteGet();
        $this->log->showLog(2,"complete function showApprovallist()");
    }

    /*
     * get workflow transaction
     */

    public function getWorkflowTransactionStatus($workflowtransaction_id){

        $sql = sprintf("SELECT ws.workflow");

        return "";
    }


} // end of ClassApprovallist
?>

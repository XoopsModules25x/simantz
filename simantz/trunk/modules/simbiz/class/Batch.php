<?php


class Batch
{

  public $batch_id;
  public $batch_date;
  public $batch_docno;
  public $batch_amount;
  public $batch_remark;
  public $period;
  public $organization_id;
  public $isposted;
  public $issubmit;
  public $iscomplete;

  public $orgctrl;
  private $xoopsDB;
  private $tableprefix;

  private $log;


//constructor
   public function Batch(){
    global $xoopsDB,$log,$$tableorganization,$isadmin;


    $this->xoopsDB=$xoopsDB;
    $this->tableorganization=$tableorganization;

    $this->arrUpdateField=array(
            "period_id",
            "batchno",
            "batch_name",
            "batchdate",
            "description",
            "totaldebit",
            "totalcredit",
            "updated",
            "updatedby",
            "iscomplete",
            "reuse",
            "tax_type");

        $this->arrUpdateFieldType=array("%d","%s","%s","%s","%s","%f","%f","%s","%d","%d","%d","%d");

        $this->arrInsertField=array(
            "period_id",
            "batchno",
            "batch_name",
            "batchdate",
            "description",
            "totaldebit",
            "totalcredit",
            "created",
            "createdby",
            "updated",
            "updatedby",
            "organization_id",
            "tax_type",
            "reuse",
            "track1_name",
            "track2_name",
            "track3_name");

        $this->arrInsertFieldType=array("%d","%s","%s","%s","%s","%f","%f","%s","%d","%s","%d","%d","%d","%d","%s","%s","%s");

        $this->tablename="sim_simbiz_batch";

        $this->log=$log;


   }
  /**
   * Display input form, type can be 'new', or 'edit', if new all field will be set
   * empty or 0. Or else all field data will pull from database.
   *
   * @param string type
   * @param int Batch_id
   * @return
   * @access public
   */
  public function getInputForm( $type,  $batch_id,$token  ) {
    global $defaultorganization_id,$workflowapi,$uid,$showOrganization,$havewriteperm,$defcurrencycode;


        $this->getIncludeFileMenu();
        //$this->initFormProcess();//initialize process

        $mandatorysign="<b style='color:red'>*</b>";
   if($showOrganization!=1)
        $hideOganization="style='display:none'";
   else
        $hideOganization="";
        $header=""; // parameter to display form header
        $action="";
        if($this->isposted==1 || $this->isposted=='on')
            $selectY="selected";
        else
            $selectN="selected";

        if($havewriteperm==1){ //user with write permission can edit grid, have button
                $getListButton = $this->getListButton($this->batch_id);
        }
        else{ //user dun have write permission, cannot save grid
                 $getListButton = "";
                  $noperm="<div>You are no write permission</div>";
        }


        if($this->batch_id > 0)
        $stylechild = "";
        else
        $stylechild = "style='display:none'";

        //$workflow_history = $workflowapi->showWorkflowHistory($this->window_workflow,$this->batch_id);

        $getFinalTotal = $this->getFinalTotal($this->batch_id);

	$orgctrl="";
	$this->created=0;
	if ($type=="new"){
		$header="New";
		$action="create";
	 	$header_text = "New Batch";
                $this->iscomplete = 0;
                $this->tax_type = 1;
                $this->batchno = getNewCode($this->xoopsDB,"batchno","sim_simbiz_batch");
                //$getFinalTotal = "";

                 //  $this->claimdetailsmsg="<div id='claimdetailsmsg'>Fill in and save the above form first</div>";

                $iframesrc="batch.php?action=getbatchline&allowedit=0&batch_id='-1'";
                $checked="CHECKED";

	}
	else
	{

                $action="update";
                $header_text = "View Batch";

                if($this->isreadonly==0){

                    if($this->iscomplete==0){
                            $readonlyctrl="";
                    }
                    else{
                            $readonlyctrl="readonly='readonly'";
                            if($this->iscomplete==-1)
                                   $iscompletemsg="<b style='color:red'>Reversed Transaction, it is a history but will not effect accounting report</b>";
                            else
                                    $iscompletemsg="Completed Transaction";
                    }

                }
                else{
                    $readonlyctrl="readonly='readonly'";
                    if($this->iscomplete==-1)
                                   $iscompletemsg="<b style='color:red'>Reversed Transaction, it is a history but will not effect accounting report</b>";
                            else
                                    $iscompletemsg="Completed Transaction, you cannot change this transaction due to it post from another program.";
                }//end else from check isreadonly field



		if($this->isAdmin)
		$recordctrl="<form target='_blank' action='../simantz/recordinfo.php' method='POST'>".
		"<input name='tablename' value='sim_simbiz_batch' type='hidden'>".
		"<input name='id' value='$this->batch_id' type='hidden'>".
		"<input name='idname' value='batch_id' type='hidden'>".
		"<input name='title' value='Accounting Transaction' type='hidden'>".
		"<input name='btnView' value='View Record Info' type='submit'>".
		"</form>";

               $iframesrc="batch.php?action=getbatchline&allowedit=1&batch_id=$this->batch_id";
		//force isactive checkbox been checked if the value in db is 'Y'
		if ($this->isactive==1)
			$checked="CHECKED";
		else
			$checked="";


		$header="Edit";
                if( $isfinance==1){
                $posted="<tr><td class='head'>Posted</td><td class='even'>
                           <select name='isposted' id='isposted'>
                             <option value='1' $selectY>Yes</option>
                             <option value='0' $selectN>No</option>
                           </select>
                          </td></tr>";
               // $this->claimdetailsmsg="<div id='claimdetailsmsg'></div>";
                }
	}


    $searchctrl="<Form action='batch.php' method='POST'>
                            <input name='btnSearch' value='Search' type='submit'>
                            <input name='action' value='search' type='hidden'>
                            </form>";

    $selectedtax1 = "";
    $selectedtax2 = "";
    $selectedtax3 = "";
    if($this->tax_type == 1){
        $selectedtax1 = "selected";
    }else if($this->tax_type == 2){
        $selectedtax2 = "selected";
    }else if($this->tax_type == 3){
        $selectedtax3 = "selected";
    }

    //force reuse checkbox been checked if the value in db is 'Y'
    if ($this->reuse==1)
    $checked="CHECKED";
    else
    $checked="";



    echo <<< EOF


<script type="text/javascript">

    var init_cell = 11;

jQuery(document).ready((function (){


}));



            function deleteBatch(){
            var batch_id = document.forms['frmBatch'].batch_id.value;
            var msg = "";
                if(confirm("Confirm to delete record?")){

                    if(batch_id > 0){
                        document.getElementById("action").value = "delete";

                        var data = $("#idBatchForm").serialize();

                        $.ajax({
                         url: "batch.php",type: "POST",data: data,cache: false,
                             success: function (xml) {

                                jsonObj = eval( '(' + xml + ')');

                                var status = jsonObj.status;
                                var msg = jsonObj.msg;


                                if(status == 1){


                                self.location = "batch.php";

                                }else{
                                document.getElementById("action").value = "edit";
                                }

                                document.getElementById("msgbox").innerHTML=msg;
                        }});
                        return false;
                    }
                }
            }

            function activateBatch(){
            var batch_id = document.forms['frmBatch'].batch_id.value;
            var msg = "";

            if(confirm("Confirm to activate record?")){

            data = "action=activatebatch&batch_id="+batch_id;

            $.ajax({
                 url: "batch.php",type: "POST",data: data,cache: false,
                     success: function (xml) {


                        jsonObj = eval( '(' + xml + ')');

                        var status = jsonObj.status;
                        var msg = jsonObj.msg;
                        var workflowbtn = jsonObj.workflowbtn;

                        if(status == 1){
                        if(workflowbtn != 'none' && workflowbtn != '')
                        document.getElementById("idListButton").innerHTML = workflowbtn;

                        document.getElementById("iscomplete").value = "0";
                        search();
                        document.getElementById("batchno").removeAttribute('readOnly');
                        document.getElementById("batchdate").removeAttribute('readOnly');
                        document.getElementById("description").removeAttribute('readOnly');
                        document.getElementById("batch_name").removeAttribute('readOnly');
    
                        document.getElementById("msgbox").innerHTML="Record activated successfully.";

                        }



                }});

            }

            }

            function saveBatch(iscomplete){

            //start form validation
            var batchdate = document.forms['frmBatch'].batchdate.value;
            var batchno = document.forms['frmBatch'].batchno.value;
            var batch_name = document.forms['frmBatch'].batch_name.value;
            var totaldebit = document.forms['frmBatch'].totaldebit.value;
            var totalcredit = document.forms['frmBatch'].totalcredit.value;
            var msg = "";

            var isallow = true;
            var errorMsg = "";

            if(confirm("Confirm to save record?")){

            $("#batchdate").removeClass('validatefail');
            $("#batch_name").removeClass('validatefail');
            $("#totaldebit").removeClass('validatefail');
            $("#totalcredit").removeClass('validatefail');

            if(iscomplete == 1){//if complete button

                if(totaldebit == 0 || totalcredit == 0){

                    isallow = false;
                    errorMsg += "<br/><b>Total Debit or Total Credit is 0.00</b>";
                    $("#totaldebit").addClass('validatefail');
                    $("#totalcredit").addClass('validatefail');

                }else if(totaldebit != totalcredit){

                    isallow = false;
                    errorMsg += "<br/><b>Total Debit and Total Credit is not balance.</b>";
                    $("#totaldebit").addClass('validatefail');
                    $("#totalcredit").addClass('validatefail');

                }else{


                    var grid= nitobi.getGrid('DataboundGrid');
                    var total_row = grid.getDisplayedRowCount();

                    for(var i = 0; i < total_row; i++){

                    var line_accountchild = grid.getCellObject(i,0);

                        if(line_accountchild.getValue() == 0){
                                isallow = false;
                        }

                    }

                    if(isallow == false){
                        errorMsg += "<br/><b>Please define all account line.</b>";
                    }else{
                        
                        document.getElementById("iscomplete").value = "1";
                        document.getElementById("batchno").setAttribute('readOnly','readonly');
                        document.getElementById("description").setAttribute('readOnly','readonly');
                        document.getElementById("batchdate").setAttribute('readOnly','readonly');
                        document.getElementById("batch_name").setAttribute('readOnly','readonly');
                        msg = "Record completed successfully.";
                      
                    }



                }


            }


            if(!IsNumeric(batchno) || batchno == ""){
                isallow = false;
                errorMsg += "<br/><b>Batch No. is numeric field</b>";
                $("#batchno").addClass('validatefail');

            }

            if(!isDate(batchdate)){
                isallow = false;
                errorMsg += "<br/><b>Date</b>";
                $("#batchdate").addClass('validatefail');
            }

            if(batch_name == ""){
                isallow = false;
                errorMsg += "<br/><b>Bacth Name</b>";
                $("#batch_name").addClass('validatefail');

            }

            if(isallow){
            var data = $("#idBatchForm").serialize();
            
             document.getElementById('popupmessage').innerHTML="Please Wait...";
             popup('popUpDiv');

            $.ajax({
                 url: "batch.php",type: "POST",data: data,cache: false,
                     success: function (xml) {


                        jsonObj = eval( '(' + xml + ')');

                        var status = jsonObj.status;
//                        if(msg == "")
                        var msg = jsonObj.msg;
                        var batch_id = jsonObj.batch_id;
                        var workflowbtn = jsonObj.workflowbtn;

                        if(status == 1){
                        document.getElementById("action").value = "update";
                        document.getElementById("batch_id").value = batch_id;
                        document.getElementById("idHeaderText").innerHTML = "View Batch";

                        if(workflowbtn != 'none' && workflowbtn != '')
                        document.getElementById("idListButton").innerHTML = workflowbtn;

                        var grid = nitobi.getGrid('DataboundGrid');
                        var datatable = grid.getDataSource();
                        datatable.setSaveHandlerParameter("batch_id", batch_id);
                        grid.save();

                        datatable.setGetHandlerParameter("batch_id", batch_id);

                        //grid.dataBind();

                        //save();

                        msg = "Record saved  successfully.";
                          reloadBatch();

                        }else{
                        //document.getElementById("action").value = "create";
                        //document.getElementById("batch_id").value = 0;
                        //document.getElementById("msgbox").innerHTML=msg;
                        }
                        //location = "batch.php?action=getbatchline&allowedit=1&batch_id="+batch_id;
                        document.getElementById("msgbox").innerHTML=msg;

                        popup('popUpDiv');

                }});
                //return false;


            }
            else{

                document.getElementById("msgbox").innerHTML="<div class='statusmsg'>Failed to save record...Please Check :<br/>"+errorMsg+"</div>";
                //document.getElementById("statusDiv").innerHTML="Failed to save record...Please Check :<br/>"+errorMsg;
                }


            }

          }


          function updateTaxColumn(tax_type){


                var grid = nitobi.getComponent("DataboundGrid");
                var total_row = grid.getDisplayedRowCount();

                var line_taxchild = grid.getColumnObject(init_cell-3);
                var line_totaltaxchild = grid.getColumnObject(init_cell+7);

                if(tax_type == 1){//if no tax

                    line_taxchild.setEditable(false);

                    var total_row = grid.getDisplayedRowCount();

                    for(var i = 0; i < total_row; i++){

                        var line_taxchild = grid.getCellObject(i,init_cell-3);
                        var line_totaltaxchild = grid.getCellObject(i,init_cell+7);

                        line_taxchild.setValue(0);
                        line_totaltaxchild.setValue(0);

                    }

                    sumDebitCreditLine();

                }else{
                line_taxchild.setEditable(true);
                }

          }

    function reuseBatch(){


        if(confirm("Confirm to re-use record?")){

        document.forms['frmBatch'].action.value = "reuse";

        var data = $("#idBatchForm").serialize();


        $.ajax({
                 url: "batch.php",type: "POST",data: data,cache: false,
                     success: function (xml) {

                        jsonObj = eval( '(' + xml + ')');

                        var status = jsonObj.status;
                        var msg = jsonObj.msg;
                        var newbatch_id = jsonObj.batch_id;

                        document.getElementById("msgbox").innerHTML=msg;

                        if(status == 1){
                        document.forms['frmBatch'].batch_id.value = newbatch_id;
                        setTimeout("redirect_batch();",2000);;
                        }
                }});

        }

    }

    function redirect_batch(newbatch_id){
    var newbatch_id = document.forms['frmBatch'].batch_id.value;
    self.location = 'batch.php?action=edit&batch_id='+newbatch_id;
    }

function reloadBatch(){
    
    if(document.getElementById("batch_id").value>0)
            window.location="batch.php?action=edit&batch_id="+document.getElementById("batch_id").value
    else
        window.location="batch.php";
    }
</script>
<div id='blanket' style='display:none;'></div>
<div id='popUpDiv' style='display:none;verticle-align:center'>
<div id='popupmessage' style='text-align:center'></div><div id='progressimage' style='text-align:center'><img src='../simantz/images/ajax_indicator_01.gif'></div>
</div>
    <br/>
 <div align="center" >
    <table style="width:990px;text-align: left; " ><tr><td align="left">$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr></table>
$noperm
 <form $formsubmit method="post" id="idBatchForm" action="batch.php" name="frmBatch"  enctype="multipart/form-data">
<table style="width:140px;">
<tbody>
<td></td></tbody></table>

<input name="currentrow" id="currentrow" value="" type="hidden">
<input name="action" id="action" value="$action" type="hidden">
<input name="batch_id" id="batch_id" value="$this->batch_id" type="hidden">
<input name="iscomplete" id="iscomplete" value="$this->iscomplete" type="hidden">

  <table style="text-align: left; width: 990px;" border="0" cellpadding="0" cellspacing="1"  class="searchformblock">
    <tbody>
        <tr>
        <td colspan="6" rowspan="1" align="center" id="idHeaderText" class="searchformheader" >$header_text</td>
        </tr>
        <tr $hideOganization>
          <td class="head">Organization $mandatorysign</td>
            <td class="even">$this->orgctrl</td>

        </tr>

        <tr>
        <td class="head">Batch No. $mandatorysign</td>
        <td class="even"><input id='batchno' name='batchno' value="$this->batchno" size='24' $readonlyctrl></td>
        <td class="head" >Date</td>
        <td class="even">
        <input name='batchdate' id='batchdate' value="$this->batchdate" maxlength='10' size='10' $readonlyctrl>
        <input name='btnDate' value="Date" type="button" onclick="$this->batchdatectrl">
        <input type='hidden' id='period_id' name='period_id' value="$this->period_id" $readonlyctrl>
        &nbsp; Re-use
        <input type="checkbox" $checked name="reuse" id="reuse" $readonlyctrl></td>
        </tr>

        <tr>
        <td class="head">Batch Name $mandatorysign</td>
        <td class="even"><input id='batch_name' name='batch_name' value="$this->batch_name" size='24' $readonlyctrl></td>
        <td class="head" style="vertical-align:top">Description</td>
        <td class="even" colspan="3"><textarea name="description" id="description" cols="40" rows="2" $readonlyctrl>$this->description</textarea></td>
        </tr>

        <tr>
        <td class="head">Total Debit ($defcurrencycode) </td>
        <td class="even"><input id='totaldebit' name='totaldebit' value="$this->totaldebit" size='15' readonly></td>
        <td class="head">Total Credit ($defcurrencycode) </td>
        <td class="even" colspan="3"><input id='totalcredit' name='totalcredit' value="$this->totalcredit" size='15' readonly></td>
        </tr>

        <tr style="display:none"><!--currently comment as per KS request on 18-08-2010 -->
        <td class="head" colspan="4" align="right" style="padding:10px;">
            Amounts are :
            <select name="tax_type" id="tax_type" onchange="updateTaxColumn(this.value)">
            <option value="1" $selectedtax1>No Tax</option>
            <option value="2" $selectedtax2>Tax Exclusive</option>
            <!--<option value="3" $selectedtax3>Tax Inclusive</option>-->
            </select>
        </td>
        </tr>




        <tr>
        <td colspan="6"><br/>
        <!--<iframe name="ntbBatchline" id="ntbBatchline" src =$iframesrc width="100%" height="280" frameborder="0"></iframe>-->
EOF;
    $this->getBatchlineform();
echo <<< EOF
        </td>
        </tr>

        <tr height="30px" style="display:none">
        <td id='idFinalTotal' colspan="6" align="right">$getFinalTotal</td>
        </tr>

        <tr height="30px">
        <td id='idListButton' colspan="6">$getListButton <br/><small>$iscompletemsg</small>
       
</td>
        </tr>
    </tbody>

    </table>

    </form>


 <table style="width:990px;"><tr><td>$recordctrl</td></tr></table>

    </div>

EOF;
  } // end of member function getInputForm


  /*
   * Show search form
   */

  public function showSearchForm(){
    global $nitobigridthemes,$isadmin,$havewriteperm;

    $rowsperpage = "10";

    if($isadmin==1){
    $grIdColumn=10; //define primary key column index, it will set as readonly afterwards (count from 0)
      //  $deleteddefaultvalue_js="myGrid.getCellObject(rowNo,6).setValue(0);"; //if admin login got deleted column, during admin insert new record shall set it default =0 (not deleted)
    }
    else{
        $grIdColumn=9;//define primary key column index for normal user
     //   $deleteddefaultvalue_js="";
    }

//    if($havewriteperm==1){ //user with write permission can edit grid, have button
//
//       $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";
//
//       $savectrl='<input name="btnAdd" onclick="addline()" value="Add New" type="button">
//         <input name="btnSave" onclick="save()" value="Save" type="button">
//         <input name="btnDelete" onclick="onclickdeletebutton()" value="Delete" type="button">';
//        $alloweditgrid= "col!=$grIdColumn";
//    }
//    else{ //user dun have write permission, cannot save grid
//       $savectrl="";
//       $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
//       $alloweditgrid= "false";
//    }

    $savectrl="";
    $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
    $alloweditgrid= "false";

echo <<< EOF

<script language="javascript" type="text/javascript">

  //  jQuery(document).ready((function (){}));

    function init(){}

     function search(){
nitobi.loadComponent('DataboundGrid');
        var grid = nitobi.getGrid("DataboundGrid");
        var searchbatch_no=document.getElementById("searchbatch_no").value;
        var searchbatch_name=document.getElementById("searchbatch_name").value;

        var batchdatefrom =document.getElementById('batchdatefrom').value;
        var batchdateto =document.getElementById('batchdateto').value;

        var reusesearch =document.getElementById("reusesearch").value;
        var iscompletesearch =document.getElementById("iscompletesearch").value;

        var searchTxt = "";

        if(batchdatefrom != "")
        searchTxt += "Date From : "+batchdatefrom+"<br/>";
        if(batchdateto != "")
        searchTxt += "Date To : "+batchdateto+"<br/>";

        if(searchbatch_no != "")
        searchTxt += "Batch no : "+searchbatch_no+"<br/>";
        if(searchbatch_name != "")
        searchTxt += "Batch Name : "+searchbatch_name+"<br/>";

        if(reusesearch != ""){
            if(reusesearch == 1)
            reusesearchname = "Y";
            else
            reusesearchname = "N";
            searchTxt += "Re-Use : "+reusesearchname+"<br/>";
        }
        if(iscompletesearch != ""){
            if(iscompletesearch == 1)
            iscompletesearchname = "Y";
            else
            iscompletesearchname = "N";
            searchTxt += "Is Complete : "+iscompletesearchname+"<br/>";
        }


        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        //if(document.getElementById("searchisdeleted"))
        //var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchbatch_no',searchbatch_no);
	grid.getDataSource().setGetHandlerParameter('searchbatch_name',searchbatch_name);
  	grid.getDataSource().setGetHandlerParameter('batchdatefrom',batchdatefrom);
	grid.getDataSource().setGetHandlerParameter('batchdateto',batchdateto);

	grid.getDataSource().setGetHandlerParameter('reusesearch',reusesearch);
	grid.getDataSource().setGetHandlerParameter('iscompletesearch',iscompletesearch);

        document.getElementById('rightBox').innerHTML = searchTxt;
        //reload grid data

	grid.dataBind();
    Pager.First('DataboundGrid');
    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
//		var myAjaxRequest = new nitobi.ajax.HttpRequest();
//
//		// Define the url for your generatekey script
//		//myAjaxRequest.handler = 'batch.php?rnd=' + Math.random();
//                myAjaxRequest.handler = 'batch.php?action=searchgrid&';
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
                     	 document.getElementById('msgbox').innerHTML="Record saved successfully";
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
             //grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }


    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){

//                    row=eventArgs.getCell().getRow();
//                    col=eventArgs.getCell().getColumn();
//                    var myGrid = nitobi.getGrid('DataboundGrid');
//                    var myCell = myGrid.getCellObject(row, col);
//
//                    var objectVal = myGrid.getCellObject(row, $grIdColumn);
//                    var batch_id = objectVal.getValue();
//
//                    if(col == $grIdColumn){
//                    return
//                    }

    }

    //add line button will call this
    function addline(){
//    var g= nitobi.getGrid('DataboundGrid');
//        g.insertAfterCurrentRow();

    }

    //trigger save activity from javascript
   function save()
     {
   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
	   var g= nitobi.getGrid('DataboundGrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(true){//confirm("Confirm the changes? Data will save into database immediately")
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
    function viewlog(){
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var cellObj = g.getCellValue(selRow, 11);
      window.open(cellObj,"");
    }

   function editbatch(){
   	var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        var editbatch = g.getCellValue(selRow, 9);
      window.open(editbatch);
    }
</script>

   <table style="width:943px;" align="center"><tr><td>$this->addnewctrl</td><td align="right">$this->searchctrl</td></tr></table>

   <table style="width:943px;" align="center">
    <tr><td align="center"  class="searchformheader">Search Form</td></tr>

    <tr  class="searchformblock">
    <td>
EOF;
        $this->headerSearchForm();
echo <<< EOF
    </td>
    </tr>

    <tr>
    <td>
    <div align="center">
    <input type="hidden" id="totalRowGrid" value="$rowsperpage">
    <table style="width:943px;"><tr><td class="head tdPager">
    $savectrl

     &nbsp;&nbsp;<a href="printbatchlist.php?rcode=$this->rcode" target="_blank" title="Print List"><img src="images/printer.png"></a>

    <div id="pager_control" class="inline">
    <div id="pager_first" class="inline FirstPage" onclick="Pager.First('DataboundGrid');" onmouseover="this.className+=' FirstPageHover';" onmouseout="this.className='inline FirstPage';" style="margin:0;border-right:1px solid #B1BAC2;"></div>
    <div id="pager_prev" class="inline PreviousPage" onclick="Pager.Previous('DataboundGrid');" onmouseover="this.className+=' PreviousPageHover';" onmouseout="this.className='inline PreviousPage';" style="margin:0;"></div>
    <div class="inline" style="height:22px;top:3px;">
        <span class="inline">Page</span>
        <span class="inline" id="pager_current">0</span>
        <span class="inline">of</span>
        <span class="inline" id="pager_total">0</span>
    </div>
    <div id="pager_next" class="inline NextPage" onclick="Pager.Next('DataboundGrid');" onmouseover="this.className+=' NextPageHover';" onmouseout="this.className='inline NextPage';" style="margin:0;border-right:1px solid #B1BAC2;"></div>
    <div id="pager_last" class="inline LastPage" onclick="Pager.Last('DataboundGrid');" onmouseover="this.className+=' LastPageHover';" onmouseout="this.className='inline LastPage';" style="margin:0;"></div>
    </div>
    </td></tr></table>
    </td>
    </tr>

        <!--     savehandler="batch.php?action=save"  -->
    <tr>
        <td align="center">
        <ntb:grid id="DataboundGrid"
             mode="standard"
             toolbarenabled='false'
             $permctrl
             ondatareadyevent="HandleReady(eventArgs);"
             onhandlererrorevent="showError()"
             oncellclickevent="clickrecord(eventArgs)"
             keygenerator="GetNewRecordID()"
             gethandler="batch.php?action=searchgrid&rcode=$this->rcode"
             onbeforecelleditevent="checkAllowEdit(eventArgs)"
             onafterrowinsertevent="setDefaultValue(eventArgs)"
             width="943"
             height="245"
             onaftersaveevent="savedone(eventArgs)"
             onbeforerowdeleteevent="beforeDelete()"
             onafterrowdeleteevent="save()"
             autosaveenabled="false"
             rowhighlightenabled="true"
             theme="$nitobigridthemes"
             rowsperpage="$rowsperpage"
             >

           <ntb:columns>
           <ntb:textcolumn classname="{\$rh}" width="25" label="No." xdatafld="seq_no" ></ntb:textcolumn>
           <ntb:textcolumn classname="{\$rh}" width="110" label="Batch No." xdatafld="batchno" ></ntb:textcolumn>
           <ntb:textcolumn classname="{\$rh}" width="100" label="Date" xdatafld="batchdate" ></ntb:textcolumn>
           <ntb:textcolumn classname="{\$rh}" width="200" label="Batch Name" xdatafld="batch_name" ></ntb:textcolumn>
           <ntb:textcolumn classname="{\$rh}" width="80" label="Completed" xdatafld="iscomplete" ></ntb:textcolumn>
           <ntb:textcolumn classname="{\$rh}" width="50" label="Re-Use" xdatafld="reuse" ></ntb:textcolumn>
           <ntb:textcolumn classname="{\$rh}" width="100" label="User" xdatafld="uname" ></ntb:textcolumn>
           <ntb:textcolumn classname="{\$rh}" width="100" label="Debit" xdatafld="totaldebit" ></ntb:textcolumn>
           <ntb:textcolumn classname="{\$rh}" width="100" label="Credit" xdatafld="totalcredit" ></ntb:textcolumn>

            <ntb:textcolumn classname="{\$rh}" label="Edit" xdatafld="operation" sortenabled="false" width="35" oncellclickevent="javascript:editbatch()" >
                    <ntb:imageeditor imageurl="images/edit.gif"></ntb:imageeditor>
            </ntb:textcolumn>
           <ntb:textcolumn classname="{\$rh}" width="0" label="" xdatafld="batch_id" ></ntb:textcolumn>


EOF;
//only admin user will see record info and isdeleted column
/*
 *            <ntb:textcolumn label="Complete" width="100" xdatafld="iscomplete" sortenabled="false">
           <ntb:checkboxeditor datasource="[{value:'1',display:'Yes'},{value:'0',display:'No'}]"
                  checkedvalue="1" uncheckedvalue="0" displayfields="display" valuefield="value"></ntb:checkboxeditor>
           </ntb:textcolumn>
 */
if($isadmin==1)
{
echo<<< EOF
<ntb:textcolumn  label="Log" classname="{\$rh}"  xdatafld="info"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:viewlog()">
            <ntb:imageeditor imageurl="images/history.gif"></ntb:imageeditor> </ntb:textcolumn>


EOF;
}

echo <<< EOF

           <ntb:numbercolumn   label=""  width="0" xdatafld="batch_id" mask="###0" sortenabled="false"></ntb:numbercolumn>

</ntb:columns>
         </ntb:grid>

        </td>
    </tr>

    <tr>
    <td><div id="msgbox" style='display:none'></div></td>
    </tr>

   </table>
EOF;
  }

  /*
   * header search form
   */
  public function headerSearchForm(){
        global $dp;
  //$this->initFormProcess();
        $stylesearchemployee = "style='display:none'";
        if($this->isAdmin)
        $stylesearchemployee = "";

echo <<< EOF
  <script language="javascript" type="text/javascript">
 jQuery(document).ready((function (){

    nitobi.loadComponent('$this->cmbDepartment');
    var list = nitobi.getComponent('$this->cmbDepartment');
    document.getElementById('$this->cmbDepartment'+''+'SelectedValue0').value = '$this->department_id';
    list.SetTextValue("$this->department_name");

 }));
</script>
        <form onsubmit="search();return false;">
    <table >
        <tr height="100px">
            <td width="70%" class="headerSearchTdTable">
                <table>

                <tr>
                <td class="head">Date From</td>
                <td class="even">
                <input id='batchdatefrom' name='batchdatefrom'>
		<input type='button' onclick="$this->showcalendarfrom" value='Date'>
                </td>
                <td class="head">Date To</td>
                <td class="even">
                <input id='batchdateto' name='batchdateto'>
		<input type='button' onclick="$this->showcalendarto" value='Date'>
                </td>
                </tr>


                <tr>
                <td class="head">Batch Name</td><td class="even"><input name="searchbatch_name" id="searchbatch_name"></td>
                <td class="head">Batch no</td><td class="even"><input name="searchbatch_no" id="searchbatch_no"></td>
                </tr>

                <tr>
                <td class="head">Re-Use</td>
                <td class="even">
                <select name="reusesearch" id="reusesearch">
                <option value=""></option>
                <option value="1">Yes</option>
                <option value="0">No</option>
                </select>
                </td>
                <td class="head">Is Complete</td>
                <td class="even">
                <select name="iscompletesearch" id="iscompletesearch">
                <option value=""></option>
                <option value="1">Yes</option>
                <option value="0">No</option>
                </select>
                </td>
                </tr>

                <tr>
                <td colspan="2"><input type="submit" value="Search"></td>
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
    </form>
EOF;

  }

  /**
   * Pull data from Batch table into class
   *
   * @return bool
   * @access public
   */
  public function fetchBatch( $batch_id) {

$this->log->showLog(3,"Fetching batch detail into class Batch.php.<br>");

	$sql="SELECT *
		 from sim_simbiz_batch where batch_id=$batch_id";

	$this->log->showLog(4,"ProductBatch->fetchBatch, before execute:" . $sql . "<br>");

	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
		$this->batch_name=htmlspecialchars($row["batch_name"]);
		$this->organization_id=$row['organization_id'];
		$this->period_id= $row['period_id'];
		$this->reuse=$row['reuse'];
		$this->fromsys=$row['fromsys'];
		$this->totaldebit=$row['totaldebit'];
		$this->totalcredit=$row['totalcredit'];
		$this->iscomplete=$row['iscomplete'];
		$this->batchdate=$row['batchdate'];
                $this->isreadonly=$row['isreadonly'];
		$this->batchno=$row['batchno'];
		$this->description=($row['description']);
                $this->tax_type=($row['tax_type']);
                $this->track1_name=htmlspecialchars($row['track1_name']);
                $this->track2_name=htmlspecialchars($row['track2_name']);
                $this->track3_name=htmlspecialchars($row['track3_name']);
   	$this->log->showLog(4,"Batch->fetchBatch,database fetch into class successfully");
	$this->log->showLog(4,"batch_name:$this->batch_name");

	$this->log->showLog(4,"reuse:$this->reuse");
	$this->log->showLog(4,"isitem:$this->isitem");

		return true;
	}
	else{
		return false;
	$this->log->showLog(4,"Batch->fetchBatch,failed to fetch data into databases:" . mysql_error(). ":$sql");
	}
  } // end of member function fetchBatch

  /**
   * Delete particular Batch id
   *
   * @param int Batch_id
   * @return bool
   * @access public
   */
  public function deleteBatchAjax( $batch_id ) {
    include_once "../simantz/class/Save_Data.inc.php";
    $save = new Save_Data();
    $this->fetchBatch($batch_id);
    return $save->DeleteRecord($this->tablename,"batch_id",$batch_id,$this->batch_docno,1);
  } // end of member function deleteBatch

  /**
   * Return select sql statement.
   *
   * @param string wherestring
   * @param string orderbystring
   * @param int startlimitno
   * @return string
   * @access public
   */

/**
   *
   * @return int
   * @access public
   */
  public function getBatchID() {
	$sql=sprintf("SELECT MAX(batch_id) as batch_id from sim_simbiz_batch WHERE createdby = '%d' ;",$this->createdby);


	$this->log->showLog(3,'Checking latest created batch_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created batch_id:' . $row['batch_id']);
		return $row['batch_id'];
	}
	else
	return -1;

  } // end


  public function getIncludeFileMenu(){
      global $xoTheme;

    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.toolkit.js");
    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js");
    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css");
    $xoTheme->addScript("$url/modules/simantz/include/validatetext.js");
    $xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
    $xoTheme->addScript("$url/modules/simantz/include/popup.js");
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');


    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.grid/paginator.js");

    $xoTheme->addScript("$url/modules/simantz/include/firefox3_6fix.js");

    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.grid/paginator.css");

    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.tabstrip/nitobi.tabstrip.css");
//    $xoTheme->addStylesheet("$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.css");
//    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.combo/nitobi.combo.js");

    $xoTheme->addScript("$url/modules/simantz/include/nitobi/nitobi.tabstrip/nitobi.tabstrip.js");

  }


  public function getFieldNameValue($tablename,$primaykey,$field_name,$field_value,$field_type){

    $sql = sprintf("SELECT $field_name as fld_name FROM $tablename WHERE $primaykey = '$field_type' ",$field_value);

    $query = $this->xoopsDB->query($sql);

    $retval = "";
    while ($row=$this->xoopsDB->fetchArray($query))
    {
    $retval = $row['fld_name'];
    }

    return $retval;
  }

  public function saveBatchAjax(){
        global $defaultorganization_id,$selectspliter,$xoopsUser,$defcurrencycode_id;
        $uname=$xoopsUser->getVar('uname');
        include "../simantz/class/Save_Data.inc.php";
        include "../simbiz/class/Track.inc.php";

        $save = new Save_Data();
        $track = new Trackclass();
        $track_array = $track->getTrackName();

        $track1_name = $track_array['track1_name'];
        $track2_name = $track_array['track2_name'];
        $track3_name = $track_array['track3_name'];

        $arrvalue=array(
        $this->period_id,
        $this->batchno,
        $this->batch_name,
        $this->batchdate,
        $this->description,
        $this->totaldebit,
        $this->totalcredit,
        $this->updated,
        $this->updatedby.$selectspliter.$uname,
        $this->updated,
        $this->updatedby.$selectspliter.$uname,
        $defaultorganization_id,
        $this->tax_type,
        $this->reuse,
        "$track1_name","$track2_name","$track3_name");

        return $save->InsertRecord($this->tablename,   $this->arrInsertField,
        $arrvalue,$this->arrInsertFieldType,$this->batchno,"batch_id");
  }

/*
 * update Batch using ajax
 */

  public function updateBatchAjax(){
        global $defaultorganization_id,$selectspliter,$xoopsUser;
        $timestamp=date("Y-m-d H:i:s",time());

        $uname=$xoopsUser->getVar('uname');
        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();

        $arrvalue=array(
        $this->period_id,
        $this->batchno,
        $this->batch_name,
        $this->batchdate,
        $this->description,
        $this->totaldebit,
        $this->totalcredit,
        $timestamp,
        $this->updatedby.$selectspliter.$uname,
        $this->iscomplete,
        $this->reuse,
        $this->tax_type);

        $saveparent = $save->UpdateRecord($this->tablename,"batch_id",
                $this->batch_id,$this->arrUpdateField,
                $arrvalue,$this->arrUpdateFieldType,$this->batchno);

        $this->failfeedback = $save->failfeedback;

        return $saveparent;

  }

 /*
 * activate Batch using ajax
 */

  public function activateBatchAjax(){
        global $defaultorganization_id,$selectspliter,$xoopsUser;
        $uname=$xoopsUser->getVar('uname');
        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();

        $arrvalue=array(
        $this->updated,
        $this->updatedby.$selectspliter.$uname,
        "0");

        $arrUpdateField=array(
            "updated",
            "updatedby",
            "iscomplete");

        $arrUpdateFieldType=array("%s","%d","%d");

        return $save->UpdateRecord($this->tablename,"batch_id",
                $this->batch_id,$arrUpdateField,
                $arrvalue,$arrUpdateFieldType,$this->batchno);

  }

/*
 * submit Batch using ajax
 */

  public function submitBatchAjax(){
        global $defaultorganization_id;

        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();

        if($this->isposted=="on" || $this->isposted==1)
              $this->isposted=1;
        else
            $this->isposted=0;

        $arrvalue=array(
        $this->employee_id.$selectspliter.$this->employee_name,
        $this->batch_date,
        $this->batch_docno,
        $this->batch_totalamount,
        $this->batch_remark,
        $this->period_id.$selectspliter.$this->period_name,
        $this->updated,
        $this->updatedby.$selectspliter.$uname,
        $this->isposted,
        "1");

        return $save->UpdateRecord($this->tablename,"batch_id",
                $this->batch_id,$this->arrUpdateField,
                $arrvalue,$this->arrUpdateFieldType,$this->batch_docno);

  }

  /*
   * initialize form process
   */




  public function getListButton($batch_id){
        global $workflowapi;

        $this->fetchBatch($batch_id);

        $action = "create";
        if($batch_id > 0)
        $action = "edit";

        switch ($action){

            case "create" :
                //$rstctrl='<input type="reset" value="Reset">';
                $savectrl='<input type="button" value="Save" onclick="saveBatch(0)">';
            break;

            case "edit" :

                if($this->isreadonly == 1){
                    $savectrl='';
                    $completectrl = '';
                    $deletectrl='';
                    $msgstatus='<b style="color:red">System controlled record, you have readonly permission.</b>';
                    $reloadbtn='<input type="button" value="Reload" onclick=javascript:reloadBatch()>';
                    if($this->reuse == 1)
                    $reusectrl = '<input type="button" value="Re-Use" onclick="reuseBatch()"><br/>';
                }
                else if($this->reuse == 1){
                    $savectrl='<input type="button" value="Save" onclick="saveBatch(0)">';
                    $completectrl = '<input type="button" value="Complete" onclick="saveBatch(1)">';
                    $reusectrl = '<input type="button" value="Re-Use" onclick="reuseBatch()">';
                    $deletectrl='<input type="button" value="Delete" onclick="deleteBatch()">';
                    $reloadbtn='<input type="button" value="Reload" onclick=javascript:reloadBatch()>';
                    $msgstatus='';
                }

                if($this->iscomplete == 0){
                    //$rstctrl='<input type="reset" value="Reset">';
                    $savectrl='<input type="button" value="Save" onclick="saveBatch(0)">';
                    $completectrl = '<input type="button" value="Complete" onclick="saveBatch(1)">';
                    $reloadbtn='<input type="button" value="Reload" onclick=javascript:reloadBatch()>';
                    $deletectrl='<input type="button" value="Delete" onclick="deleteBatch()">';
                    $msgstatus='';
                }else if($this->iscomplete == 1 && $this->isreadonly==0){
                    $savectrl='<input type="button" value="Activate" onclick="activateBatch()">';
                    $msgstatus='';
                    $completectrl = '';
                    $reloadbtn='<input type="button" value="Reload" onclick=javascript:reloadBatch()>';
                    $deletectrl='';
                }



            break;

            default:
            break;

        }

        $html = ''.$rstctrl.' '.$savectrl.' '.$completectrl.' '.$reusectrl.' '.' '.$reloadbtn. ' '.$deletectrl.''.$msgstatus;



        return $html;
  }

  /*
   * define parameter for workflow in array
   */

  public function defineWorkflowParameter(){

        /* start define hod */
        include_once "../hr/class/Employee.php";
        $emp = new Employee();

        $hod_uid = $emp->getHODDepartmentID($this->createdby);


        /* end */
      return $parameter_array = array(
                                '{own_uid}'=>$this->createdby,
                                '{hod_uid}'=>$hod_uid,
                                '{email_list}'=>'',
                                '{sms_list}'=>'',
                                '{total_amount}'=>$this->batch_totalamount,
                                '{period}'=>$this->period_name
                                    );

  }

  /*
   * define header button
   */

  public function defineHeaderButton(){
           global $action;
    $this->addnewctrl='<form action="batch.php" ><input type="submit" value="Add New"></form>';
        if($action=="search"){
    $this->searchctrl='';
    }
    else
    $this->searchctrl='<form action="batch.php?action=search" ><input type="hidden" name="action" value="search"><input type="submit" value="Search"></form>';
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
   * nitobi Batch grid
   */
  public function  showBatchGrid($wherestring){
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

    include_once "../simantz/class/EBAGetHandler.php";
    $getHandler = new EBAGetHandler();


    //var_dump($_GET['StartRecord']) ;
    $this->log->showLog(3,"Load showBatchGrid with Query String=".$_SERVER['QUERY_STRING']);

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
        $sortdirection=$_GET["SortDirection"];



    $tablename="sim_simbiz_batch";

    $searchbatch_no=$_GET['searchbatch_no'];
    $searchbatch_name=$_GET['searchbatch_name'];
    $batchdatefrom=$_GET['batchdatefrom'];
    $batchdateto=$_GET['batchdateto'];
    $reusesearch=$_GET['reusesearch'];
    $iscompletesearch=$_GET['iscompletesearch'];


        if($batchdatefrom=="")
		$batchdatefrom="0000-00-00";
	if($batchdateto=="")
		$batchdateto="9999-12-31";

	$wherestring .=" and bt.batchdate between '$batchdatefrom' and '$batchdateto' ";

	if($searchbatch_no<>"")
		$wherestring=$wherestring. " and bt.batchno LIKE '$searchbatch_no' ";

	if($reusesearch !="")
		$wherestring=$wherestring. " and bt.reuse = $reusesearch ";
        if($iscompletesearch !="")
		$wherestring=$wherestring. " and bt.iscomplete = $iscompletesearch ";
	if($searchbatch_name<>"")
		$wherestring=$wherestring. " and bt.batch_name LIKE '$searchbatch_name' ";


    $this->log->showLog(2,"Access showBatchGrid($wherestring)");

        if(empty($sortcolumn)){
           $sortcolumn="bt.batchdate DESC,bt.batchno";

        }
        if(empty($sortdirection)){
           $sortdirection="DESC";
        }
$this->log->showLog(4,"sortcolumn: $sortcolumn, sortdirection $sortdirection");

        $sql="SELECT bt.*,usr.uname
            FROM sim_simbiz_batch bt
            LEFT JOIN sim_users usr ON bt.updatedby = usr.uid
            $wherestring
            ORDER BY $sortcolumn $sortdirection";


        $rcode = $_GET['rcode'];
        $_SESSION['sql_txt_'.$rcode] = $sql;

      $this->log->showLog(4,"showBatchGrid SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("seq_no");
        $getHandler->DefineField("batchno");
     	$getHandler->DefineField("batchdate");
     	$getHandler->DefineField("batch_name");
        $getHandler->DefineField("iscomplete");
        $getHandler->DefineField("reuse");
        $getHandler->DefineField("uname");
        $getHandler->DefineField("totaldebit");
        $getHandler->DefineField("totalcredit");
        $getHandler->DefineField("operation");
        $getHandler->DefineField("batch_id");
        $getHandler->DefineField("rh");
	$currentRecord = 0; // This will assist us finding the ordinalStart position
        $i=0;
        $rh="odd";
      while ($row=$xoopsDB->fetchArray($query))
     {
            if($rh=="even")
            $rh="odd";
            else
            $rh="even";

     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $i++;
             $getHandler->CreateNewRecord($row['batch_id']);

             $getHandler->DefineRecordFieldValue("seq_no", $currentRecord);
             $getHandler->DefineRecordFieldValue("batchno", $row['batchno']);
             $getHandler->DefineRecordFieldValue("batchdate",$row['batchdate']);
             $getHandler->DefineRecordFieldValue("batch_name", $row['batch_name']);
             $getHandler->DefineRecordFieldValue("iscomplete",($row['iscomplete'] != "1" ? "N" : "Y")) ;
             $getHandler->DefineRecordFieldValue("reuse",($row['reuse'] != "1" ? "N" : "Y")) ;
             $getHandler->DefineRecordFieldValue("uname", $row['uname']);
             $getHandler->DefineRecordFieldValue("totaldebit",$row['totaldebit']);
             $getHandler->DefineRecordFieldValue("totalcredit",$row['totalcredit']);
             $getHandler->DefineRecordFieldValue("operation","batch.php?action=edit&batch_id=".$row['batch_id']);
             $getHandler->DefineRecordFieldValue("info","../simantz/recordinfo.php?id=".$row['batch_id']."&tablename=sim_simbiz_batch&idname=batch_id&title=Journal Entry");
             $getHandler->DefineRecordFieldValue("batch_id",$row['batch_id']);
                   $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->SaveRecord();
             }
      }

        $getHandler->setErrorMessage($currentRecord);
        $getHandler->CompleteGet();
        $this->log->showLog(2,"complete function showBatch()");
    }



 //   Start Batchline Section
  public function getBatchlineform(){
    global $nitobigridthemes,$isadmin,$havewriteperm,$action,$uid,$defcurrencycode,$defaultorganization_id,$iseditbpartner;

    $this->allowedit = 1;

    $this->fetchBatch($this->batch_id);

    $editBPartner = "true";
    if($iseditbpartner == "N" || $this->fromsys != "")
    $editBPartner = "false";

    $add_imgpath = 'images/add_line.gif';
    if($this->batch_id==0 || $this->batch_id =="")
    $url_addline_img = $add_imgpath;

    $editTax = "true";
    if($this->tax_type == 1)
    $editTax = "false";

    $editabled=0;

        $grIdColumn=13;//define primary key column index for normal user
     //   $deleteddefaultvalue_js="";
        $changewidth="width='365'";

    if($havewriteperm==1){ //user with write permission can edit grid, have button

       $permctrl=" rowinsertenabled=\"true\" rowdeleteenabled=\"true\" onbeforesaveevent=\"beforesave()\"";

      if($this->allowedit==1){

          if($this->issubmit!=1 && $this->iscomplete!=1){
         $savectrl='<input id="ntbSavebtn" name="ntbSavebtn" onclick="save()" value="Save" type="button" style="display:inline">';
         $addctrl='<input id="ntbAddbtn" name="ntbAddbtn" onclick="addline()" value="Add Transaction" type="button" style="display:inline">';
         $editabled=1;
         $this->claimdetailsmsg="";
         }
         else
           $editabled=0;
      }
      else{
         $savectrl='<input id="ntbSavebtn" name="ntbSavebtn" onclick="save()" value="Save" type="button" style="display:none">';
         $addctrl='<input id="ntbAddbtn" name="ntbAddbtn" onclick="addline()" value="Add Transaction" type="button" style="display:none">';
         $this->claimdetailsmsg="";
      }
        $alloweditgrid= "col!=$grIdColumn";

    }
    else{ //user dun have write permission, cannot save grid
        $savectrl="";

       $permctrl=" rowinsertenabled=\"false\" rowdeleteenabled=\"false\" onbeforesaveevent=\"return false\" ";
       $alloweditgrid= "false";
    }

    $timestamp= date("Y-m-d", time()) ;

    $rh = "odd";

        if($this->batch_id == 0){

        
        include "../simbiz/class/Track.inc.php";
        $track = new Trackclass();
        $track_array = $track->getTrackName();

        $track1_name = $track_array['track1_name'];
        $track2_name = $track_array['track2_name'];
        $track3_name = $track_array['track3_name'];
        }else{
        $track1_name = $this->track1_name;
        $track2_name = $this->track2_name;
        $track3_name = $this->track3_name;
        }

        if($track1_name=="")
        $track1_name = "Track 1";
        if($track2_name=="")
        $track1_name = "Track 2";
        if($track3_name=="")
        $track1_name = "Track 3";

echo <<< EOF
<link rel="stylesheet" type="text/css" href="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.css" />
<script type="text/javascript" src="../simantz/include/nitobi/nitobi.calendar/nitobi.calendar.js"></script>
  <script language="javascript" type="text/javascript">

    var init_cell = 11;

    //testn = 12.054;
    //alert(Math.round(testn*100)/100);

    $(document).ready((function (){
     
        nitobi.loadComponent('DataboundGrid');
        
            }));


    function roundAmtValue(val){

    return (Math.round(val*100)/100).toFixed(2);
    }

    function search(){
        var grid = nitobi.getGrid("DataboundGrid");
	grid.dataBind();
    }

    function  getTotalAmount(){


        var grid= nitobi.getGrid('DataboundGrid');
        var selRow = grid.getSelectedRow();
        var selCol = grid.getSelectedColumn();
        var total_row = grid.getDisplayedRowCount();

        var typeline_cell = grid.getCellObject(selRow, init_cell+4);
        var temp_parent_cell = grid.getCellObject(selRow, init_cell+6);
        var debit_cell = grid.getCellObject(selRow, init_cell-5);
        var cerdit_cell = grid.getCellObject(selRow, init_cell-4);

        var parent_val = temp_parent_cell.getValue();
        var typeline_val = typeline_cell.getValue();

        var parent_col = init_cell-5;
        var child_col = init_cell-4;
        if(selCol == (init_cell-5)){//is debit
            if(debit_cell.getValue() > 0 ){
            cerdit_cell.setValue('0.00');

            parent_col = init_cell-4;
            child_col = init_cell-5;
           }
        else{
            parent_col = init_cell-5;
            child_col = init_cell-4;

        }
        }else if(selCol == (init_cell-4)){//is credit
            if(cerdit_cell.getValue() > 0 ){
            debit_cell.setValue('0.00');

            parent_col = init_cell-5;
            child_col = init_cell-4;
           }else{
                    parent_col = init_cell-4;
            child_col = init_cell-5;

            }
        }

        var currentrow = document.getElementById('currentrow').value;
        if(typeline_val == 2 && selRow == currentrow){//if child do update parent
        updateTotalParent(parent_val,parent_col,child_col,0);
        }

        sumDebitCreditLine();


    }

    function updateTotalParent(parent_val,parent_col,child_col,sub_value){

        var grid= nitobi.getGrid('DataboundGrid');
        var total_row = grid.getDisplayedRowCount();
        
        var sum_col_val = 0;
        
        for(var i = 0; i < total_row; i++){

            var typeline_cell = grid.getCellObject(i, init_cell+4);
            var temp_parent_cell = grid.getCellObject(i, init_cell+6);
            var line_debitchild = grid.getCellObject(i,init_cell-5);
            var line_creditchild = grid.getCellObject(i,init_cell-4);

            var parent_line = temp_parent_cell.getValue();
            var typeline_line = typeline_cell.getValue();
            var debit_line = line_debitchild.getValue();
            var credit_line = line_creditchild.getValue();

            if(parent_val == parent_line){//if same parent

                if(typeline_line == 1){//if parent
                update_col_1 = grid.getCellObject(i,parent_col);
                update_col_2 = grid.getCellObject(i,child_col);
                }else{
                sum_col = grid.getCellObject(i,child_col);
                sum_col_val = parseFloat(sum_col_val) + parseFloat(sum_col.getValue());
                
                }



            }


        }

        if(i > 0){
        sum_col_val = parseFloat(sum_col_val) - parseFloat(sub_value);
        update_col_1.setValue(sum_col_val);
        update_col_2.setValue("0.00");
        }

    }

    function sumDebitCreditLine(){

        var grid= nitobi.getGrid('DataboundGrid');
        var total_row = grid.getDisplayedRowCount();

        ColTxt1 = "Subtotal";
        ColTxt2 = "";
        ColTxt3 = "";

        var finalSubTotalArr= new Array();
        var finalTotalDebitArr= new Array();
        var finalTotalCreditArr= new Array();
        var init_total = "";
        var totalTaxDebitFinal = 0;
        var totalTaxCreditFinal = 0;
        var j = 0;
        var k = 0;
        total_debit_ori = 0;
        total_credit_ori = 0;
        total_debit = 0;
        total_credit = 0;
        debit_amt_tax = 0;
        credit_amt_tax = 0;

        for(var i = 0; i < total_row; i++){

            var line_taxchild = grid.getCellObject(i,init_cell-3);
            var line_debitchild = grid.getCellObject(i,init_cell-5);
            var line_creditchild = grid.getCellObject(i,init_cell-4);
            var line_totaltaxchild = grid.getCellObject(i,init_cell+7);

            var val_taxchild = line_taxchild.getValue();
            var val_debitchild = line_debitchild.getValue();
            var val_creditchild = line_creditchild.getValue();
            var val_totaltaxchild = line_totaltaxchild.getValue();

            var debit_amt = val_debitchild;
            var credit_amt = val_creditchild;

            total_debit_ori = parseFloat(total_debit_ori) + parseFloat(debit_amt);
            total_credit_ori = parseFloat(total_credit_ori) + parseFloat(credit_amt);


            if(false){//val_totaltaxchild > 0 : not use
                j++;


                var totalTaxDebit = countTotalTax(val_totaltaxchild,val_debitchild);//(parseFloat(val_totaltaxchild)/100)*parseFloat(val_debitchild);
                var totalTaxCredit = countTotalTax(val_totaltaxchild,val_creditchild);//(parseFloat(val_totaltaxchild)/100)*parseFloat(val_creditchild);

                /* start define col for final total */

                if(init_total != val_totaltaxchild){
                var totalTaxDebitFinal = 0;
                var totalTaxCreditFinal = 0;
                var debit_amt_tax = 0;
                var credit_amt_tax = 0;
                }


                var prevDebit = finalTotalDebitArr[val_totaltaxchild*100];
                if(prevDebit == undefined)
                prevDebit = 0;

                var prevCredit = finalTotalCreditArr[val_totaltaxchild*100];
                if(prevCredit == undefined)
                prevCredit = 0;


                debit_amt_tax = parseFloat(debit_amt_tax) + parseFloat(debit_amt);
                credit_amt_tax = parseFloat(credit_amt_tax) + parseFloat(credit_amt);


                finalSubTotalArr[val_totaltaxchild*100] = val_totaltaxchild;
                finalTotalDebitArr[val_totaltaxchild*100] = parseFloat(prevDebit) + parseFloat(debit_amt_tax);
                finalTotalCreditArr[val_totaltaxchild*100] = parseFloat(prevCredit) + parseFloat(credit_amt_tax);

                /* end */

                debit_amt = parseFloat(debit_amt) + totalTaxDebit;
                credit_amt = parseFloat(credit_amt) + totalTaxCredit;


            }

            total_debit = parseFloat(total_debit) + parseFloat(debit_amt);
            total_credit = parseFloat(total_credit) + parseFloat(credit_amt);

            total_debit = roundAmtValue(parseFloat(total_debit));
            total_credit = roundAmtValue(parseFloat(total_credit));

            total_debit_ori = roundAmtValue(parseFloat(total_debit_ori));
            total_credit_ori = roundAmtValue(parseFloat(total_credit_ori));


        }

            /* start update value */

            document.getElementById("totaldebit").value=total_debit;
            document.getElementById("totalcredit").value=total_credit;
            /* not use
            //start final total

            for(i in finalSubTotalArr){ // in returns key, not object

                if(finalSubTotalArr[i] != undefined){

                    var taxTot = finalSubTotalArr[i];
                    var debitTot = finalTotalDebitArr[parseFloat(taxTot*100)];
                    var creditTot = finalTotalCreditArr[parseFloat(taxTot*100)];


                    var debitTotFinal = countTotalTax(taxTot,debitTot);//(parseFloat(taxTot)/100)*parseFloat(debitTot);
                    var creditTotFinal = countTotalTax(taxTot,creditTot);//(parseFloat(taxTot)/100)*parseFloat(creditTot);

                    ColTxt1 += "<br/><br/>Total Tax "+taxTot+"%";
                    ColTxt2 += "<br/><br/>"+roundAmtValue(debitTotFinal);
                    ColTxt3 += "<br/><br/>"+roundAmtValue(creditTotFinal);
                }

            }


            ColTxt2 = total_debit_ori+""+ColTxt2;


            ColTxt3 = total_credit_ori+""+ColTxt3;

            document.getElementById("idSubTotal").innerHTML=ColTxt1;
            document.getElementById("idTotalDebit").innerHTML=ColTxt2;
            document.getElementById("idTotalCredit").innerHTML=ColTxt3;

            document.getElementById("idFinalTotalDebit").innerHTML=total_debit;
            document.getElementById("idFinalTotalCredit").innerHTML=total_credit;
            */




    }


    function countTotalTax(tax_value,amt_value){

    var retval = "0.00";

    retval = (parseFloat(tax_value)/100)*parseFloat(amt_value);

    return parseFloat(retval);

    }

    function  updateCurrentRow(eventArgs){

        row=eventArgs.getCell().getRow();

        document.getElementById('currentrow').value = row;
    }

    function  getTotalAmountCell(eventArgs){

        row=eventArgs.getCell().getRow();
        col=eventArgs.getCell().getColumn();
        var grid= nitobi.getGrid('DataboundGrid');

        if(false){//if tax : col == init_cell-3

        var line_taxchild = grid.getCellObject(row,init_cell-3);
        var line_totaltaxchild = grid.getCellObject(row,init_cell+7);

        var val_taxchild = line_taxchild.getValue();
     
        var data = "action=getTotalTax&tax_id="+val_taxchild;

        $.ajax({
         url: "batch.php",type: "POST",data: data,cache: false,
             success: function (xml) {

                var total_tax = 0;

                if(xml != ""){
                jsonObj = eval( '(' + xml + ')');

                var total_tax = jsonObj.total_tax;
                }


                total_tax = roundAmtValue(parseFloat(total_tax));

                line_totaltaxchild.setValue(total_tax);

                sumDebitCreditLine();
        }});




        }else if((col == init_cell-5) || (col == init_cell-4)){//if debit | credit
        getTotalAmount();

        }

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
        refreshGrid();
    }

    //Call event after save complete
    function savedone(eventArgs){
        var grid= nitobi.getGrid('DataboundGrid');
        var dataSource =grid.getDataSource();
        var errorMessage = dataSource.getHandlerError();

        if (!errorMessage) {//save successfully
        	         jQuery('#msgbox').fadeTo('slow', 1, function() {
                     	 document.getElementById('msgbox').innerHTML="Record saved successfully";
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
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
           jQuery('#msgbox').fadeTo('slow', 1, function() {});
    }

    //if user click particular column, auto fall into edit mode
    function clickrecord(eventArgs){
                    alert("fds");
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var  myGrid = nitobi.getGrid('DataboundGrid');
                    var myCell = myGrid.getCellObject(row, col);
                    myCell.edit();
    }

    //add line button will call this
    function addline(){

            if($this->isreadonly==0 && $this->iscomplete==0){

            var grid= nitobi.getComponent('DataboundGrid');
            grid.insertRow();
            document.getElementById('line_type').value = "1";

            var grid= nitobi.getComponent('DataboundGrid');
            grid.insertRow();
        }

    }

    //trigger save activity from javascript
   function save()
     {

   	if(document.getElementById("afterconfirm").value==1){  //Ask for confirmation from delete activity already, process data immediately
           var g= nitobi.getGrid('DataboundGrid');
	   document.getElementById("afterconfirm").value=0;
	   g.save();
           }
	else{ // not yet request confirmation
    	  if(true){//confirm("Confirm the changes? Data will save into database immediately")
     	    var g= nitobi.getGrid('DataboundGrid');
	    document.getElementById("afterconfirm").value=0;

	    g.save();

	    search();
    	   }
	}

    }

    function beforesave(){
        document.getElementById('popupmessage').innerHTML="Please Wait.....";
        popup('popUpDiv');
    }

   function onclickdeletebutton(){ //when press delete button will triger this function and ask for confirmation

      if($editabled!=0){
        var g= nitobi.getGrid('DataboundGrid');
        var selRow = g.getSelectedRow();
        if(selRow==-1){// no select any row
        alert("Please choose a row before deleting.");
        return false;
        }
        else
         g.deleteCurrentRow();
      }

        sumDebitCreditLine();
    }

    function checkAllowEdit(eventArgs){
	var g= nitobi.getGrid('DataboundGrid');
        col=eventArgs.getCell().getColumn();
      if($alloweditgrid && document.getElementById("iscomplete").value==0) //if user have permission to edit the cell, control primary key column read only at here too
        return true;
       else
        return false;
        }


    //after insert a new line will automatically fill in some value here
      function setDefaultValue(eventArgs,action_type)
       {

       var myGrid = eventArgs.getSource();
       var r = eventArgs.getRow();
       var rowNo = r.Row;
       $deleteddefaultvalue_js

       myGrid.selectCellByCoords(rowNo, 0);

        /* start css */
        var grid = nitobi.getComponent("DataboundGrid");

        if(action_type == "add"){
        var linetype_new = document.getElementById('line_type').value;
        var linetype_cell = grid.getCellObject(rowNo, init_cell+4);//1st para : row , 2nd para : column seq

        if(linetype_new == 0 || linetype_new == "")
        linetype_new = 2;//set to child if 0

        linetype_cell.setValue(linetype_new);
        }else if(action_type == "delete"){

        var linetype_cell = grid.getCellObject(rowNo, init_cell+4);//1st para : row , 2nd para : column seq
        linetype_val = linetype_cell.getValue();

        if(linetype_val == 2){//if child -> do calculatation
            var debit_cell = grid.getCellObject(rowNo, init_cell-5);
            var cerdit_cell = grid.getCellObject(rowNo, init_cell-4);
            var temp_parent_cell = grid.getCellObject(rowNo, init_cell+6);

            var parent_val = temp_parent_cell.getValue();

            if(debit_cell.getValue() > 0 ){
            updateTotalParent(parent_val,init_cell-4,init_cell-5,debit_cell.getValue());
            }else{
            updateTotalParent(parent_val,init_cell-5,init_cell-4,cerdit_cell.getValue());
            }

        }
        }

        refreshGrid();
        /* end */


    }

    function refreshGrid(){
        init_cell = 10;
        var grid = nitobi.getComponent("DataboundGrid");

        var selRow = grid.getSelectedRow();
        var total_col = grid.columnCount();
        var total_row = grid.getDisplayedRowCount();

        var j = 0;
        for(var i = 0; i < total_row; i++){

            var linetype_cell = grid.getCellObject(i, init_cell+4);//1st para : row , 2nd para : column seq
            var refid_cell = grid.getCellObject(i, init_cell+5);//1st para : row , 2nd para : column seq
            var transid_cell = grid.getCellObject(i, init_cell+3);//1st para : row , 2nd para : column seq
            var seqno_cell = grid.getCellObject(i, init_cell+8);//1st para : row , 2nd para : column seq

            var linetype_val = linetype_cell.getValue();
            var refid_val = refid_cell.getValue();
            var transid_val = transid_cell.getValue();
            seqno_cell.setValue(i+1);

            if(linetype_val == 0 || linetype_val == "" || (refid_val > 0 && transid_val > 0)){
            linetype_val = 2;//set to child if 0
            linetype_cell.setValue(2);
            }

            var tempparentid_cell = grid.getCellObject(i, init_cell+6);//1st para : row , 2nd para : column seq

            var row_element = nitobi.grid.Row.getRowElement(grid,i);

            var cell_delchild = grid.getCellElement(i,init_cell+1);
            var cell_addchild = grid.getCellElement(i,init_cell+2);

            var styleCountAdd = init_cell+4;
            var styleCountDel = init_cell+4;

            if(linetype_val == 1 || (refid_val == 0 && transid_val > 0)){
            j++;
            tempparentid_cell.setValue(j);
            row_element.className="journalParent";

            var divAddImg = '<div style="overflow: hidden; white-space: nowrap;" class="ntb-rowntb__1 ntb-column-datantb__1_13 ntb-cell" title=""><div style="background-image: url(&quot;&quot;); background-repeat: no-repeat;" class="ntb-image"><img src="$add_imgpath" style="" align="middle" border="0"></div></div>';

            cell_addchild.innerHTML = divAddImg

            }else{
            tempparentid_cell.setValue(j);
            row_element.className="journalChild";

            var divDelImg = '<div style="overflow: hidden; white-space: nowrap;padding-left:0px;" class="ntb-rowntb__1 ntb-column-datantb__1_13 ntb-cell" title=""><div style="background-image: url(&quot;&quot;); background-repeat: no-repeat;" class="ntb-image"><img src="images/del.gif" style="" align="middle" border="0"></div></div>';

            cell_addchild.innerHTML = "";
            cell_delchild.innerHTML = divDelImg;
//            cell_delchild.style.paddingLeft="100px";
            //document.getElementById("cell_"+i+"_12_ntb__"+$this->createdby).innerHTML = "";
            }

        }

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

  function validateEmpty(){

        var grid= nitobi.getGrid('DataboundGrid');
        var isallow = true;
        var total_row = grid.getRowCount();
        var detail ="";
        var purpose ="";
        var bill ="";
        var amount ="";

        for( var i = 0; i < total_row; i++ ) {
        var detailcell = grid.getCellObject( i, 1);//1st para : row , 2nd para : column seq
        var purposecell = grid.getCellObject( i, 2);//1st para : row , 2nd para : column seq
        var billcell = grid.getCellObject( i, 3);//1st para : row , 2nd para : column seq
        var amountcell = grid.getCellObject( i, 4);//1st para : row , 2nd para : column seq

           detail = detailcell.getValue();
           purpose = purposecell.getValue();
           bill = billcell.getValue();
           amount = amountcell.getValue();

           if(amount=="" || amount=="0")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Amount.</a><br/>";
           }

           if(bill=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Bill/Invoice No.</a><br/>";
           }

            if(purpose=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Purpose.</a><br/>";
           }

           if(detail=="")
           {
            isallow = false;
            document.getElementById('msgbox').innerHTML="<a class=\"statusmsg\">Please enter Detail of Expenditure.</a><br/>";
           }
        }

        if(isallow)
          return true;
        else
          return false;
    }

        function onclickaddbutton(){
              if($this->isreadonly==0 && $this->iscomplete==0){
            var g= nitobi.getGrid('DataboundGrid');
            g.insertAfterCurrentRow();

            document.getElementById('line_type').value = "2";
            }
        }
        
        function shotcutinsertline(e){
        
            if(e.charCode==32)
            onclickaddbutton();
        }
        function shotcutdeleteline(e){

            if(e.charCode==32)
            onclickdeletebutton();
        }
</script>

<input type="hidden" id="line_type" value="">

<div id='blanket' style='display:none;'></div>
<div id='popUpDiv' style='display:none;verticle-align:center'>

     <div id='popupmessage' style='text-align:center'></div>d<div id='progressimage' style='text-align:center'><img src='../simantz/images/ajax_indicator_01.gif'></div>
</div>

<div align="center">
<table style="width:940px;">

<tr><td align="left">$addctrl</td></tr>
<tr><td align="center" style="background-color:#ffffff;">
<!-- onchangeevent="getTotalAmount()" onaftercelleditevent="getTotalAmountCell(eventArgs)"-->
<ntb:grid id="DataboundGrid"
     mode="nonpaging"
     toolbarenabled='false'
     $permctrl
     onhtmlreadyevent="dataready()"
     singleclickeditenabled="true"
     keygenerator="GetNewRecordID();"
     onhandlererrorevent="showError()"
     gethandler="batch.php?action=searchbatchline&batch_id=$this->batch_id"
     savehandler="batch.php?action=saveBatchline"
     onbeforecelleditevent="checkAllowEdit(eventArgs)"
     onafterrowinsertevent="setDefaultValue(eventArgs,'add')"
     rowhighlightenabled="false"
     width="960"
     height="200"
     onaftersaveevent="savedone(eventArgs)"
     onaftercelleditevent="getTotalAmountCell(eventArgs)"
     onbeforerowdeleteevent="setDefaultValue(eventArgs,'delete')"
     autosaveenabled="false"
     theme="$nitobigridthemes">

 <ntb:columns>


    <ntb:textcolumn classname="{\$rh}" width="170" label="Account"  xdatafld="accounts_cell" sortenabled="false">
        <ntb:listboxeditor gethandler="simbizlookup.php?action=getaccountlistgrid" displayfields="accounts_name" valuefield="accounts_id" ></ntb:listboxeditor>
            </ntb:textcolumn>

    <ntb:textcolumn classname="{\$rh}" width="170" label="B.Partner"  xdatafld="bpartner_cell" sortenabled="false" editable="$editBPartner">
    <ntb:listboxeditor gethandler="simbizlookup.php?action=searchbpartnergrid" displayfields="bpartner_name" valuefield="bpartner_id" ></ntb:listboxeditor>
            </ntb:textcolumn>

    <ntb:textcolumn classname="{\$rh}" label="Cheque No." width="60" xdatafld="document_no2" sortenabled="false"></ntb:textcolumn>

    <ntb:textcolumn classname="{\$rh}" label="Doc No." width="60" xdatafld="document_no" sortenabled="false" editable="true"></ntb:textcolumn>
    <ntb:textcolumn classname="{\$rh}" label="Memo"  width="125"  xdatafld="linedesc" sortenabled="false"><ntb:textareaeditor></ntb:textareaeditor></ntb:textcolumn>

    <ntb:numbercolumn classname="{\$rh}" label="Debit($defcurrencycode)" oncellvalidateevent="updateCurrentRow(eventArgs)" mask="#0.00" width="70" xdatafld="amt_debit" sortenabled="false"></ntb:numbercolumn>

    <ntb:numbercolumn classname="{\$rh}" label="Credit($defcurrencycode)" oncellvalidateevent="updateCurrentRow(eventArgs)" mask="#0.00" width="70" xdatafld="amt_credit" sortenabled="false"></ntb:numbercolumn>

    <ntb:textcolumn classname="{\$rh}" width="50" label="Branch"  xdatafld="organization_cell" sortenabled="false" initial="$defaultorganization_id">
            <ntb:listboxeditor gethandler="simbizlookup.php?action=getbranchlistgrid" displayfields="organization_code" valuefield="organization_id" ></ntb:listboxeditor>
    </ntb:textcolumn>

    <ntb:textcolumn classname="{\$rh}" visible="false"   width="40" label="$track1_name"  xdatafld="track1_cell" sortenabled="false">
    <ntb:listboxeditor gethandler="simbizlookup.php?action=gettracklist1grid" displayfields="track_name" valuefield="track_id" ></ntb:listboxeditor>
    </ntb:textcolumn>

    <ntb:textcolumn classname="{\$rh}" visible="false"  width="40" label="$track2_name"  xdatafld="track2_cell" sortenabled="false">
    <ntb:listboxeditor gethandler="simbizlookup.php?action=gettracklist2grid" displayfields="track_name" valuefield="track_id" ></ntb:listboxeditor>
    </ntb:textcolumn>

    <ntb:textcolumn classname="{\$rh}" visible="false"  width="40" label="$track3_name"  xdatafld="track3_cell" sortenabled="false">
    <ntb:listboxeditor gethandler="simbizlookup.php?action=gettracklist3grid" displayfields="track_name" valuefield="track_id" ></ntb:listboxeditor>
    </ntb:textcolumn>

EOF;

 echo <<< EOF

      <ntb:textcolumn label=""   xdatafld="imgdel"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickdeletebutton()" align="right" onkeypressevent=javascrpt:shotcutdeleteline(eventArgs)>
      <ntb:imageeditor imageurl="images/del.gif"></ntb:imageeditor> </ntb:textcolumn>
      <ntb:textcolumn label=""   xdatafld="imgadd"    width="25"  sortenabled="false" classname="{\$rh}" oncellclickevent="javascript:onclickaddbutton()" align="center" onkeypressevent=javascrpt:shotcutinsertline(eventArgs)>
      <ntb:imageeditor imageurl="$url_addline_img" ></ntb:imageeditor> </ntb:textcolumn>

      <ntb:numbercolumn    visible="false" label=""  width="0" xdatafld="trans_id" mask="###0" sortenabled="false"></ntb:numbercolumn>

      <ntb:numbercolumn visible="false"   label=""  width="0" xdatafld="row_typeline" mask="###0" sortenabled="false"></ntb:numbercolumn>
      <ntb:numbercolumn visible="false"   label=""  width="0" xdatafld="reference_id" mask="###0" sortenabled="false"></ntb:numbercolumn>
      <ntb:numbercolumn visible="false"   label=""  width="0" xdatafld="temp_parent_id" mask="###0" sortenabled="false"></ntb:numbercolumn>
      <ntb:numbercolumn visible="false"   label=""  width="0" xdatafld="total_tax" sortenabled="false" initial="0.00"></ntb:numbercolumn>
      <ntb:numbercolumn visible="false"   label=""  width="0" xdatafld="seqno" sortenabled="false" mask="###0"></ntb:numbercolumn>

        <ntb:textcolumn visible="false" classname="{\$rh}" width="0" label=""  xdatafld="tax_cell" sortenabled="false" editable="$editTax">
        <ntb:lookupeditor delay="1000" gethandler="simbizlookup.php?action=gettaxlistgrid" displayfields="tax_name" valuefield="tax_id"></ntb:lookupeditor>
        </ntb:textcolumn>

   </ntb:columns>
 </ntb:grid>

</td></tr>

<tr><td align="left">
<input id='afterconfirm' value='0' type='hidden'>

<div id="msgbox" class="blockContent"></div>
<div id="statusDiv"></div>
</td></tr></table></div>




EOF;
  }

  public function showBatchline($wherestring){

    include "../simantz/class/nitobi.xml.php";
    $getHandler = new EBAGetHandler();

   $this->log->showLog(3,"Load Grid with Query String=".$_SERVER['QUERY_STRING']);
        $pagesize=$_GET["PageSize"];
        $ordinalStart=$_GET["StartRecordIndex"];
        $sortcolumn=$_GET["SortColumn"];
        $sortdirection=$_GET["SortDirection"];
    global $xoopsDB,$wherestring,$xoopsUser,$isadmin;

   $tablename="sim_simbiz_transaction";
   $this->log->showLog(2,"Access showBatchline($wherestring)");
    if(empty($pagesize)){
          $pagesize=$this->defaultpagesize;
        }
        if(empty($ordinalStart)){
          $ordinalStart=0;
        }
        if(empty($sortcolumn)){
           $sortcolumn="batchline_date";
        }
        if(empty($sortdirection)){
           $sortdirection="DESC";
        }

        $orderbystr = " temp_parent_id ASC, row_typeline ASC, seqno ASC, trans_id DESC ";

      ////$sql = "SELECT * FROM $tablename $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
        $sql = "SELECT bt.*,tx.total_tax FROM $tablename bt
        LEFT JOIN sim_simbiz_tax tx ON bt.tax_id = tx.tax_id
        $wherestring ORDER BY $orderbystr ";
      $this->log->showLog(4,"With SQL: $sql");
        $query = $xoopsDB->query($sql);

        $getHandler->ProcessRecords();
        $getHandler->DefineField("trans_id");
        $getHandler->DefineField("accounts_cell");
        $getHandler->DefineField("bpartner_cell");
     	$getHandler->DefineField("document_no2");
        $getHandler->DefineField("organization_cell");
     	$getHandler->DefineField("track1_cell");
     	$getHandler->DefineField("track2_cell");
     	$getHandler->DefineField("track3_cell");
        $getHandler->DefineField("amt_debit");
        $getHandler->DefineField("amt_credit");
        $getHandler->DefineField("document_no");
        $getHandler->DefineField("rh");
        $getHandler->DefineField("row_typeline");
        $getHandler->DefineField("reference_id");
        $getHandler->DefineField("temp_parent_id");
        $getHandler->DefineField("linedesc");
        $getHandler->DefineField("imgadd");
        $getHandler->DefineField("seqno");


        $getHandler->DefineField("tax_cell");
        $getHandler->DefineField("total_tax");
//        $getHandler->DefineField("currency_id");


	$currentRecord = 0; // This will assist us finding the ordinalStart position
        $rh="odd";
        $temp_parent_id = 0;
      while ($row=$xoopsDB->fetchArray($query))
     {

            $url_addimg = "images/add_line.gif";


//            if($row['row_typeline'] == 1 ){
//            $rh="journalParent";
//            }else{
//            $rh="journalChild";
//            $url_addimg = "";
//            }

            if($row['reference_id'] == 0 ){

                $rh="journalParent";
                if($row['row_typeline'] == 0)
                $row['row_typeline'] = 1;

                if($row['temp_parent_id'] == 0){
                    $temp_parent_id++;
                    $row['temp_parent_id'] = $temp_parent_id;
                }


            }else{
                $rh="journalChild";
                $url_addimg = "";
                if($row['row_typeline'] == 0)
                $row['row_typeline'] = 2;

                if($row['temp_parent_id'] == 0){
                    $row['temp_parent_id'] = $temp_parent_id;
                }
            }

            //$total_tax = getTotalTax($row['tax_id']);
            $amt_debit = "0.00";
            $amt_credit = "0.00";
            if($row['amt'] > 0)
            $amt_debit = $row['amt'];
            else if($row['amt'] < 0)
            $amt_credit = -1*$row['amt'];

     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
             $getHandler->CreateNewRecord($row['trans_id']);
             $getHandler->DefineRecordFieldValue("trans_id", $row['trans_id']);
             $getHandler->DefineRecordFieldValue("accounts_cell", $row['accounts_id']);
             $getHandler->DefineRecordFieldValue("bpartner_cell", $row['bpartner_id']);
             $getHandler->DefineRecordFieldValue("document_no2",$row['document_no2']);
             $getHandler->DefineRecordFieldValue("organization_cell", $row['branch_id']);
             $getHandler->DefineRecordFieldValue("track1_cell", $row['track_id1']);
             $getHandler->DefineRecordFieldValue("track2_cell", $row['track_id2']);
             $getHandler->DefineRecordFieldValue("track3_cell",$row['track_id3']);
             $getHandler->DefineRecordFieldValue("amt_debit",$amt_debit);
             $getHandler->DefineRecordFieldValue("amt_credit",$amt_credit);
             $getHandler->DefineRecordFieldValue("document_no",$row['document_no']);
             $getHandler->DefineRecordFieldValue("rh",$rh);
             $getHandler->DefineRecordFieldValue("row_typeline",$row['row_typeline']);
             $getHandler->DefineRecordFieldValue("temp_parent_id",$row['temp_parent_id']);
             $getHandler->DefineRecordFieldValue("imgadd",$url_addimg);
             $getHandler->DefineRecordFieldValue("linedesc",$row['linedesc']);
             $getHandler->DefineRecordFieldValue("reference_id",$row['reference_id']);
             $getHandler->DefineRecordFieldValue("tax_cell",$row['tax_id']);
             $getHandler->DefineRecordFieldValue("total_tax",$row['total_tax']);
             $getHandler->DefineRecordFieldValue("seqno",$row['seqno']);
//             $getHandler->DefineRecordFieldValue("currency_id",$row['currency_id']);
             $getHandler->SaveRecord();
             }
      }
    $getHandler->CompleteGet();
          $this->log->showLog(2,"complete function showBatchline()");
    }

  public function saveBatchline(){
        $this->log->showLog(3,"Access saveBatchline");
            include "../simantz/class/nitobi.xml.php";
            include_once "../simantz/class/Save_Data.inc.php";

            global $xoopsDB,$xoopsUser,$defcurrencycode_id;
            $saveHandler = new EBASaveHandler();
            $saveHandler->ProcessRecords();
            $timestamp=date("Y-m-d H:i:s",time());
            $createdby=$xoopsUser->getVar('uid');
            $uname=$xoopsUser->getVar('uname');
            $uid=$xoopsUser->getVar('uid');

            $tablename="sim_simbiz_transaction";

            $this->multiplyconversion = 1;

            $this->log->showLog(3,"Get batch_id:$batch_id");
            $save = new Save_Data();


            /* run update 1st */

    $updateCount = $saveHandler->ReturnUpdateCount();
    $this->log->showLog(3,"Start update($updateCount records)");

    if ($updateCount > 0)
    {
          $arrfield=array("document_no","amt","originalamt","tax_id",
                          "currency_id","document_no2","accounts_id",
                          "multiplyconversion","seqno","bpartner_id","isreconciled","bankreconcilation_id",
                          "transtype","linedesc","reconciledate","branch_id","track_id1","track_id2","track_id3",
                          "created","createdby","row_typeline","temp_parent_id");
          $arrfieldtype=array('%s','%f','%f','%d',
                          '%d','%s','%d',
                          '%f','%d','%d','%d','%d',
                          '%s','%s','%s',
                          '%d','%d','%d','%d','%s','%d','%d','%d');
     // Yes there are UPDATEs to perform...

     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++){
             $this->log->showLog(3,"***updating record($currentRecord),new batchline_details:".
                    $saveHandler->ReturnUpdateField($currentRecord, "batchline_details").",id:".
                    $saveHandler->ReturnUpdateField($currentRecord)."\n");
             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "batchline_details");
     }

     for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
     {

//            $reference_id = 0;
            $row_typeline = $saveHandler->ReturnUpdateField($currentRecord,"row_typeline");
            $temp_parent_id = $saveHandler->ReturnUpdateField($currentRecord,"temp_parent_id");
//            if($row_typeline == 2)
//            $reference_id = $this->getLatestGridParentID($temp_parent_id);

             $amt = $saveHandler->ReturnUpdateField($currentRecord,"amt_debit");
             if($saveHandler->ReturnUpdateField($currentRecord,"amt_credit") > 0)
             $amt = -1*$saveHandler->ReturnUpdateField($currentRecord,"amt_credit");

            $arrvalue=array(
                    $saveHandler->ReturnUpdateField($currentRecord,"document_no"),
                    $amt,
                    $amt,
                    $saveHandler->ReturnUpdateField($currentRecord,"tax_cell"),
                    $defcurrencycode_id,
                    $saveHandler->ReturnUpdateField($currentRecord,"document_no2"),
                    $saveHandler->ReturnUpdateField($currentRecord,"accounts_cell"),
                    $this->multiplyconversion,
                    $saveHandler->ReturnUpdateField($currentRecord,"seqno"),
                    $saveHandler->ReturnUpdateField($currentRecord,"bpartner_cell"),
                    $this->isreconciled,
                    $this->bankreconcilation_id,
                    $this->transtype,
                    $saveHandler->ReturnUpdateField($currentRecord,"linedesc"),
                    $this->reconciledate,
                    $saveHandler->ReturnUpdateField($currentRecord,"organization_cell"),
                    $saveHandler->ReturnUpdateField($currentRecord,"track1_cell"),
                    $saveHandler->ReturnUpdateField($currentRecord,"track2_cell"),
                    $saveHandler->ReturnUpdateField($currentRecord,"track3_cell"),
                    $timestamp,
                    $createdby,
                    $row_typeline,
                    $temp_parent_id);

            $this->log->showLog(3,"***updating record($currentRecord),new batchline_details:".
                   $saveHandler->ReturnUpdateField($currentRecord, "batchline_details").",id:".
                   $saveHandler->ReturnUpdateField($currentRecord,"batchline_id")."\n");

             $controlvalue=$saveHandler->ReturnUpdateField($currentRecord, "trans_id");

             $save->UpdateRecord($tablename, "trans_id", $saveHandler->ReturnUpdateField($currentRecord,"trans_id"),
                        $arrfield, $arrvalue, $arrfieldtype,$controlvalue);
  if($save->failfeedback!=""){
      $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
      $this->failfeedback.=$save->failfeedback;
  }

     }
    }


/*run delete 1st*/
            $ispurge=0;
    $deleteCount = $saveHandler->ReturnDeleteCount();
    $this->log->showLog(3,"Start delete/purge($deleteCount records)");
    //include "class/Country.inc.php";
    //$o = new Country();

    if ($deleteCount > 0){
      for($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++){
        $record_id=$saveHandler->ReturnDeleteField($currentRecord);
       // $this->fetchDisciplineline($record_id);
        $controlvalue=$this->trans_id;
        $isdeleted=1;

        $save->DeleteRecord("sim_simbiz_transaction","trans_id",$record_id,$controlvalue,$isdeleted);

      }

      }
      /* start insert after update all row*/


            $insertCount = $saveHandler->ReturnInsertCount();
            $this->log->showLog(3,"Start Insert($insertCount records)");


    if ($insertCount > 0)
    {
          $arrfield=array("batch_id", "document_no","amt","originalamt","tax_id",
                          "currency_id","document_no2","accounts_id",
                          "multiplyconversion","seqno","reference_id","bpartner_id","isreconciled","bankreconcilation_id",
                          "transtype","linedesc","reconciledate","branch_id","track_id1","track_id2","track_id3",
                          "created","createdby","row_typeline","temp_parent_id");
          $arrfieldtype=array('%d', '%s','%f','%f','%d',
                            '%d','%s','%d',
                            '%f','%d','%d','%d','%d','%d',
                            '%s','%s','%s','%d','%d','%d','%d',
                            '%s','%d','%d','%d');

    // Yes there are INSERTs to perform... for parent
     for ($currentRecord = ($insertCount-1); $currentRecord >= 0; $currentRecord--)
     {

         $reference_id = 0;
         $row_typeline = $saveHandler->ReturnInsertField($currentRecord,"row_typeline");
         $temp_parent_id = $saveHandler->ReturnInsertField($currentRecord,"temp_parent_id");
//         if($row_typeline == 2)
//         $reference_id = $this->getLatestGridParentID($temp_parent_id);

         if($row_typeline == 1){


         $amt = $saveHandler->ReturnInsertField($currentRecord,"amt_debit");
         if($saveHandler->ReturnInsertField($currentRecord,"amt_credit") > 0)
         $amt = -1*$saveHandler->ReturnInsertField($currentRecord,"amt_credit");

         $arrvalue=array($this->batch_id,
                    $saveHandler->ReturnInsertField($currentRecord,"document_no"),
                    $amt,
                    $amt,
                    $saveHandler->ReturnInsertField($currentRecord,"tax_cell"),
                    $defcurrencycode_id,
                    $saveHandler->ReturnInsertField($currentRecord,"document_no2"),
                    $saveHandler->ReturnInsertField($currentRecord,"accounts_cell"),
                    $this->multiplyconversion,
                    $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                    $reference_id,
                    $saveHandler->ReturnInsertField($currentRecord,"bpartner_cell"),
                    $this->isreconciled,
                    $this->bankreconcilation_id,
                    $this->transtype,
                    $saveHandler->ReturnInsertField($currentRecord,"linedesc"),
                    $this->reconciledate,
                    $saveHandler->ReturnInsertField($currentRecord,"organization_cell"),
                    $saveHandler->ReturnInsertField($currentRecord,"track1_cell"),
                    $saveHandler->ReturnInsertField($currentRecord,"track2_cell"),
                    $saveHandler->ReturnInsertField($currentRecord,"track3_cell"),
                    $timestamp,
                    $createdby,
                    $row_typeline,
                    $temp_parent_id);

         $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "trans_id");

         $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"trans_id");
          if($save->failfeedback!=""){
              $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
              $this->failfeedback.=$save->failfeedback;
          }

     }
      // Now we execute this query
     }

// Yes there are INSERTs to perform... for child
     for ($currentRecord = ($insertCount-1); $currentRecord >= 0; $currentRecord--)
     {

         $reference_id = 0;
         $row_typeline = $saveHandler->ReturnInsertField($currentRecord,"row_typeline");
         $temp_parent_id = $saveHandler->ReturnInsertField($currentRecord,"temp_parent_id");
         if($row_typeline == 2)
         $reference_id = $this->getLatestGridParentID($temp_parent_id);

         if($row_typeline == 2){




         $amt = $saveHandler->ReturnInsertField($currentRecord,"amt_debit");
         if($saveHandler->ReturnInsertField($currentRecord,"amt_credit") > 0)
         $amt = number_format(-1*$saveHandler->ReturnInsertField($currentRecord,"amt_credit"),2);

         $arrvalue=array($this->batch_id,
                    $saveHandler->ReturnInsertField($currentRecord,"document_no"),
                    $amt,
                    $amt,
                    $saveHandler->ReturnInsertField($currentRecord,"tax_cell"),
                    $defcurrencycode_id,
                    $saveHandler->ReturnInsertField($currentRecord,"document_no2"),
                    $saveHandler->ReturnInsertField($currentRecord,"accounts_cell"),
                    $this->multiplyconversion,
                    $saveHandler->ReturnInsertField($currentRecord,"seqno"),
                    $reference_id,
                    $saveHandler->ReturnInsertField($currentRecord,"bpartner_cell"),
                    $this->isreconciled,
                    $this->bankreconcilation_id,
                    $this->transtype,
                    $saveHandler->ReturnInsertField($currentRecord,"linedesc"),
                    $this->reconciledate,
                    $saveHandler->ReturnInsertField($currentRecord,"organization_cell"),
                    $saveHandler->ReturnInsertField($currentRecord,"track1_cell"),
                    $saveHandler->ReturnInsertField($currentRecord,"track2_cell"),
                    $saveHandler->ReturnInsertField($currentRecord,"track3_cell"),
                    $timestamp,
                    $createdby,
                    $row_typeline,
                    $temp_parent_id);

         $controlvalue=$saveHandler->ReturnInsertField($currentRecord, "trans_id");

         $save->InsertRecord($tablename, $arrfield, $arrvalue, $arrfieldtype,$controlvalue,"trans_id");
          if($save->failfeedback!=""){
              $save->failfeedback = str_replace($this->failfeedback,"",$save->failfeedback);
              $this->failfeedback.=$save->failfeedback;
          }

     }
      // Now we execute this query
     }


    }




    /* end insert */

    if($this->failfeedback!="")
    $this->failfeedback="Warning!<br/>\n".$this->failfeedback;
    $saveHandler->setErrorMessage($this->failfeedback);
    $saveHandler->CompleteSave();

    }


  // end of member function fetchDiscipline


   public function getselectDepartment($employee_id){
       global $xoopsDB;

     $retval = 0;
     $sql = sprintf("SELECT dp.department_name FROM sim_hr_employee emp
            LEFT JOIN sim_hr_department dp ON emp.department_id = dp.department_id
            WHERE emp.employee_id=%d;",$employee_id);
    $this->log->showLog(4,"getselectDepartment SQL: $sql");
    $rs=$this->xoopsDB->query($sql);
    if($row=$this->xoopsDB->fetchArray($rs)){
    $retval = $row['department_name'];
    }

    return $retval;
   }

   public function getTotalamount($tax_id,$val_debitchild,$val_creditchild){
       global $xoopsDB;

        $retval = 0;
        $sql = sprintf("SELECT * FROM sim_simbiz_tax WHERE tax_id = '%d' ",$tax_id);
        $this->log->showLog(4,"getTotalamount SQL: $sql");
        $rs=$this->xoopsDB->query($sql);
        if($row=$this->xoopsDB->fetchArray($rs)){
        $total_tax = $row['total_tax'];
        }

        $debit_amt = $val_debitchild + ($total_tax/100)*$val_debitchild;
        $credit_amt = $val_creditchild + ($total_tax/100)*$val_creditchild;

    return array("debit_amt"=>$debit_amt,"credit_amt"=>$credit_amt);
   }

   public function getTotalTax($tax_id){
       global $xoopsDB;

        $retval = 0;
        $sql = sprintf("SELECT * FROM sim_simbiz_tax WHERE tax_id = '%d' ",$tax_id);
        $this->log->showLog(4,"getTotalTax SQL: $sql");
        $rs=$this->xoopsDB->query($sql);
        if($row=$this->xoopsDB->fetchArray($rs)){
        $retval = $row['total_tax'];
        }

    return $retval;
   }

   public function includeGeneralFile(){
      global $url;

echo <<< EOF
<script src="$url/modules/simantz/include/validatetext.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/popup.js" type="text/javascript"></script>
<script src="$url/browse.php?Frameworks/jquery/jquery.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.toolkit.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/firefox3_6fix.js" type="text/javascript"></script>
<script src="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.js" type="text/javascript"></script>


<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.grid/paginator.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/popup.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/modules/simantz/include/nitobi/nitobi.grid/nitobi.grid.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/xoops.css">
<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="$url/themes/default/style.css">
EOF;

  }


public function getSelectAccount($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectAccount()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring,$iseditbpartner,$searchstring;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="accountcode_full";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }


        if($iseditbpartner == "N")
        $wherestring .= " and ac.account_type NOT IN (2,3) ";

   // $wherestring .= " and concat(ac.accountcode_full,'-',ac.accounts_name) LIKE '%$searchstring%'";
       $sql = "SELECT ac.accounts_id,concat(ac.accountcode_full,'-',ac.accounts_name) as accounts_name FROM sim_simbiz_accounts ac
              $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql," );
       $this->log->showLog(4," search string: $searchstring, Request:".print_r($_REQUEST,true) );

       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["accounts_id"]);
                       $getHandler->DefineRecordFieldValue("accounts_id", $row["accounts_id"]);
                       $getHandler->DefineRecordFieldValue("accounts_name", $row["accounts_name"] );
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  }

public function getSelectBpartner($wherestring) {

        $this->log->showLog(2,"Run lookup getSelectBpartner()");

        global $getHandler,$pagesize,$ordinalStart,$sortcolumn,$sortdirection,$wherestring;

        if(empty($pagesize)){
          $pagesize=$defaultpagesize;
        }

        if(empty($ordinalStart)){
          $ordinalStart=0;
        }

        if(empty($sortcolumn)){
           $sortcolumn="bpartner_name";
        }

        if(empty($sortdirection)){
           $sortdirection="ASC";
        }
       $sql = "SELECT * FROM sim_bpartner lk
              $wherestring ORDER BY " . $sortcolumn . " " . $sortdirection .";";
       $this->log->showLog(4," with SQL: $sql");
       $query = $this->xoopsDB->query($sql);

       $currentRecord = 0; // This will assist us finding the ordinalStart position
      while ($row=$this->xoopsDB->fetchArray($query))
     {
     	    $currentRecord = $currentRecord +1;
            if($currentRecord > $ordinalStart){
                       $getHandler->CreateNewRecord($row["bpartner_id"]);
                       $getHandler->DefineRecordFieldValue("bpartner_id", $row["bpartner_id"]);
                       $getHandler->DefineRecordFieldValue("bpartner_name", $row["bpartner_name"] );
                       $getHandler->SaveRecord();
           //  $getHandler->CompleteGet();

            }
      }
  }



	public function checkPeriodID($date){
	$retval = 0;
	$year = substr($date,0,4);
	$month = (int)substr($date,5,2);
	$sql = "select * from sim_period
		where period_year = $year and period_month = $month ";

	$this->log->showLog(4,"Checking period date with SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['period_id'];
	}

	return $retval;

  	}

        public function getLatestGridParentID($temp_parent_id){
	$retval = 0;
	$sql = sprintf("SELECT * from sim_simbiz_transaction
		where createdby = '%d' AND row_typeline = '1' AND temp_parent_id = '%d'
                AND created <> '0000-00-00 00:00:00'
                ORDER BY created DESC,trans_id DESC LIMIT 1",$this->createdby,$temp_parent_id);

	$this->log->showLog(4,"getLatestGridParentID with SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['trans_id'];
	}

	return $retval;
        }

        public function getFinalTotal($batch_id){


            //$getFinalTotalDetailRow = $this->getFinalTotalDetailRow();
            //                            LEFT JOIN sim_simbiz_tax tx ON tr.tax_id = tx.tax_id


            $sql = sprintf("SELECT bt.tax_type,tx.total_tax,tr.tax_id,
                            SUM(CASE WHEN tr.amt > 0 THEN tr.amt
                            ELSE 0
                            END) as total_debit,
                            SUM(CASE WHEN tr.amt < 0 THEN -1*tr.amt
                            ELSE 0
                            END) as total_credit

                            FROM sim_simbiz_transaction tr
                            INNER JOIN sim_simbiz_batch bt ON tr.batch_id = bt.batch_id
                            LEFT JOIN sim_simbiz_tax tx ON tr.tax_id = tx.tax_id
                            WHERE tr.batch_id = '%d'
                            GROUP BY tx.total_tax ",$batch_id);

            $this->log->showLog(4,"getFinalTotal with SQL:$sql");
            $query=$this->xoopsDB->query($sql);

            $col_1 = "";
            $col_2 = "";
            $col_3 = "";
            $total_debit = 0;
            $total_credit = 0;
            $total_debit_tax = 0;
            $total_credit_tax = 0;
            $i=0;
            while($row=$this->xoopsDB->fetchArray($query)){
            $i++;

                $tax_type = $row['tax_type'];
                $total_tax = $row['total_tax'];
                $tax_id = $row['tax_id'];

                $total_debit += $row['total_debit'];
                $total_credit += $row['total_credit'];

                if($total_tax > 0){

                    if(true){//$tax_type == 2 : exclusive, 3 : inclusive

                        $col_1 .= "<br/><br/>";
                        $col_1 .= "Total Tax $total_tax%";

                        $col_2 .= "<br/><br/>";
                        $col_2 .= number_format(($total_tax/100)*$row['total_debit'],2,".","");

                        $col_3 .= "<br/><br/>";
                        $col_3 .= number_format(($total_tax/100)*$row['total_credit'],2,".","");
                    }
                }

            }


            $html = '';

            $html .= '<table class="tblFinalTotal">';

            $html .= '<tr class="finalTotalRow1">
                        <td class="tdFinalTotal"></td>
                        <td class="td1FinalTotal" id="idSubTotal">Subtotal'.$col_1.'</td>
                        <td class="td2FinalTotal" id="idTotalDebit">'.number_format($total_debit,2,".","").''.$col_2.'</td>
                        <td class="td3FinalTotal" id="idTotalCredit">'.number_format($total_credit,2,".","").''.$col_3.'</td>
                    </tr>';

            $html .= '<tr class="finalTotalRow2">
                        <td class="tdFinalTotal2"></td>
                        <td class="td1FinalTotal2">Total</td>
                        <td class="td2FinalTotal2" id="idFinalTotalDebit">'.$this->totaldebit.'</td>
                        <td class="td3FinalTotal2" id="idFinalTotalCredit">'.$this->totalcredit.'</td>
                    </tr>';

            $html .= '</table>';

            return $html;
        }

public function reUse(){
	global $selectspliter,$xoopsUser;

        include_once "../simantz/class/Save_Data.inc.php";
        $save = new Save_Data();
        $uname=$xoopsUser->getVar('uname');

        $batchno = getNewCode($this->xoopsDB,"batchno","sim_simbiz_batch");
        $timestamp=date("Y-m-d H:i:s",time());
        $createdby=$xoopsUser->getVar('uid');

	$timestamp= date("y/m/d H:i:s", time()) ;


        $arrInsertFieldParent=array(
            "period_id",
            "batchno",
            "batch_name",
            "batchdate",
            "description",
            "totaldebit",
            "totalcredit",
            "created",
            "createdby",
            "updated",
            "updatedby",
            "organization_id",
            "tax_type",
            "isreadonly",
            "reuse");

        $arrInsertFieldTypeParent=array("%d","%s","%s","%s","%s","%f","%f","%s","%d","%s","%d","%d","%d","%d","%d");

        $arrInsertFieldChild=array(
                        "batch_id", "document_no","amt","originalamt","tax_id",
                        "currency_id","document_no2","accounts_id",
                        "multiplyconversion","seqno","reference_id","bpartner_id","isreconciled","bankreconcilation_id",
                        "transtype","linedesc","reconciledate","branch_id","track_id1","track_id2","track_id3",
                        "created","createdby","row_typeline","temp_parent_id");

        $arrInsertFieldTypeChild=array(
                        '%d', '%s','%f','%f','%d',
                        '%d','%s','%d',
                        '%f','%d','%d','%d','%d','%d',
                        '%s','%s','%s','%d','%d','%d','%d',
                        '%s','%d','%d','%d');


	$sqlheader = "select * from sim_simbiz_batch where batch_id = $this->batch_id ";

	$this->log->showLog(3,"Reuse header with SQL:$sqlheader");
	$query=$this->xoopsDB->query($sqlheader);

	if($row=$this->xoopsDB->fetchArray($query)){

	$organization_id=$row['organization_id'];
	$period_id=$row['period_id'];
	$iscomplete=0;
	$batch_name=$row['batch_name'];
	$description=$row['description'];
	$created=$timestamp;
	$createdby=$this->updatedby;
	$updated=$timestamp;
	$updatedby=$this->updatedby;
	$reuse=$row['reuse'];
	$totaldebit=$row['totaldebit'];
	$totalcredit=$row['totalcredit'];
	$fromsys=$row['fromsys'];
	$batchdate=$row['batchdate'];
	$tax_type=$row['tax_type'];
	$isreadonly=$row['isreadonly'];

        $arrvalue=array(
        $period_id,
        $batchno,
        $batch_name,
        $batchdate,
        $description,
        $totaldebit,
        $totalcredit,
        $updated,
        $updatedby.$selectspliter.$uname,
        $this->updated,
        $this->updatedby.$selectspliter.$uname,
        $organization_id,
        $tax_type,
        0,
        $reuse);

        $rs = $save->InsertRecord($this->tablename,   $arrInsertFieldParent,
        $arrvalue,$arrInsertFieldTypeParent,$batchno,"batch_id");

	if (!$rs){
		$this->log->showLog(1,"Failed to insert reuse code $batch_name:");
		return false;
	}

	}



	$nextbatchid = $this->getBatchID();

	$sqltransaction = "select * from sim_simbiz_transaction where batch_id = $this->batch_id ";

	$this->log->showLog(3,"Reuse transaction with SQL:$sqltransaction");
	$query=$this->xoopsDB->query($sqltransaction);

	$i = 0;
	while($row=$this->xoopsDB->fetchArray($query)){
	$i++;

	$document_no=$row['document_no'];
	$amt=$row['amt'];
	$originalamt=$row['originalamt'];
	$tax_id=$row['tax_id'];

	$currency_id=$row['currency_id'];
	$document_no2=$row['document_no2'];
	$transtype=$row['transtype'];
	$accounts_id=$row['accounts_id'];
	$multiplyconversion=$row['multiplyconversion'];
	$seqno=$row['seqno'];
	$reference_id=$row['reference_id'];
	$bpartner_id=$row['bpartner_id'];
	$bankreconcilation_id=0;
	$linedesc=$row['linedesc'];
	$branch_id=$row['branch_id'];
        $track_id1=$row['track_id1'];
        $track_id2=$row['track_id2'];
        $track_id3=$row['track_id3'];
        $row_typeline=$row['row_typeline'];
        $temp_parent_id=$row['temp_parent_id'];


	if($reference_id > 0)
	$reference_id = $refid;

	$arrvalue=array($nextbatchid,
                    $document_no,
                    $amt,
                    $amt,
                    $tax_id,
                    $currency_id,
                    $document_no2,
                    $accounts_id,
                    $multiplyconversion,
                    $seqno,
                    $reference_id,
                    $bpartner_id,
                    0,
                    0,
                    $transtype,
                    $linedesc,
                    "0000-00-00",
                    $branch_id,
                    $track_id1,
                    $track_id2,
                    $track_id3,
                    $timestamp,
                    $createdby,
                    $row_typeline,
                    $temp_parent_id);

         $rschild = $save->InsertRecord("sim_simbiz_transaction", $arrInsertFieldChild, $arrvalue, $arrInsertFieldTypeChild,$seqno,"trans_id");


	if (!$rschild){
		$this->log->showLog(1,"Failed to insert reuse code $batch_name:");
		return false;
	}

	if($reference_id == 0)
	$refid = $this->getLatestTransID();


	}

	return true;

	}

    public function getLatestTransID(){
        global $defaultorganization_id;

	$retval = "";
	$sql = "select * from sim_simbiz_transaction a, sim_simbiz_batch b
			where a.reference_id = 0
			and a.batch_id = b.batch_id
			and b.organization_id = $defaultorganization_id
			order by a.trans_id desc limit 1";

	$this->log->showLog(3,"Checking closing with SQL:$sql");
	$query=$this->xoopsDB->query($sql);

	if($row=$this->xoopsDB->fetchArray($query)){
	$retval = $row['trans_id'];
	}

	return $retval;
	}


public function getLatestBatchID() {
	$sql="SELECT MAX(batch_id) as batch_id from sim_simbiz_batch;";
	$this->log->showLog(3,'Checking latest created batch_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created batch_id:' . $row['batch_id']);
		return $row['batch_id'];
	}
	else
	return -1;

  } // end

  public function getNextBatchID() {
	$sql="SELECT MAX(batch_id) as batch_id from $this->tablebatch;";
	$this->log->showLog(3,'Checking latest created batch_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found latest created batch_id:' . $row['batch_id']);
		return $row['batch_id']+1;
	}
	else
	return 1;

  } // end


public function navigationRecord($batch_id,$batchdate,$batchno){

global $defaultorganization_id;
$sqlfirst="SELECT batch_id FROM
            $this->tablebatch b
            where organization_id=$defaultorganization_id
            ORDER BY batchdate ASC, batchno ASC LIMIT 0,1";
$sqlprev="SELECT batch_id FROM
            $this->tablebatch b
            where organization_id=$defaultorganization_id
            AND batchdate<='$batchdate'
            AND  batchno <= (case when batchdate = '$batchdate' then '$batchno' else '9999999999999' end)
            and batch_id <>$batch_id
            ORDER BY batchdate DESC, batchno DESC LIMIT 0,1";
$sqlnext="SELECT batch_id FROM
            $this->tablebatch b
            where organization_id=$defaultorganization_id
            AND batchdate>='$batchdate' AND batchno >=(case when batchdate = '$batchdate' then '$batchno' else '000000000' end)  and batch_id <>$batch_id
            ORDER BY batchdate ASC, batchno ASC LIMIT 0,1";
$sqllast="SELECT batch_id FROM
            $this->tablebatch b
            where organization_id=$defaultorganization_id
            ORDER BY batchdate DESC, batchno DESC LIMIT 0,1";
 $sqlall="SELECT ($sqlfirst) as firstid,($sqlprev) as previd,($sqlnext) as nextid,($sqllast) as lastid FROM DUAL";
$this->log->showLog(4,"show navigationRecord($batch_id,$batchdate,$batchno) with sql: $sqlall");
$queryall=$this->xoopsDB->query($sqlall);
$row=$this->xoopsDB->fetchArray($queryall);
$firstid=$row['firstid'];
$previd=$row['previd'];
$nextid=$row['nextid'];
$lastid=$row['lastid'];

if($firstid!=$batch_id)
$firstrecord="<a href='batch.php?action=edit&batch_id=$firstid'> &#60;&#60;First </a>";
else
$firstrecord="&#60;&#60;First ";

if($previd!="")
$prevrecord="<a href='batch.php?action=edit&batch_id=$previd'> &#60;Prev </a>";
else
$prevrecord=" &#60;Prev ";

if($nextid!="")
$nextrecord="<a href='batch.php?action=edit&batch_id=$nextid'> Next&#62; </a>";
else
$nextrecord=" Next&#62; ";

if($lastid!=$batch_id)
$lastrecord="<a href='batch.php?action=edit&batch_id=$lastid'> Last&#62;&#62; </a>";
else
$lastrecord=" Last&#62;&#62; ";

return "$firstrecord &nbsp;&nbsp;&nbsp; $prevrecord &nbsp;&nbsp;&nbsp;
        $nextrecord &nbsp;&nbsp;&nbsp; $lastrecord";
}

  public function getNextSeqNo() {

	$sql="SELECT MAX(period_id) + 10 as period_id from $this->tablebatch;";
	$this->log->showLog(3,'Checking next period_id');
	$this->log->showLog(4,"SQL: $sql");
	$query=$this->xoopsDB->query($sql);
	if($row=$this->xoopsDB->fetchArray($query)){
		$this->log->showLog(3,'Found next period_id:' . $row['period_id']);
		return  $row['period_id'];
	}
	else
	return 10;

  } // end

} // end of ClassBatch

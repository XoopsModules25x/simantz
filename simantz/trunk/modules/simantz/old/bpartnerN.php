<?php

//	include_once ('../../mainfile.php');
//	include_once (XOOPS_ROOT_PATH.'/header.php');
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

include "system.php";
include "class/BPartner.inc.php";
include "class/nitobi.xml.php";
$o = new BPartner();

$action=$_REQUEST["action"];

switch($action){
case "save":
    $o->bpartner_id=$_POST["bpartner_id"];
    $o->bpartner_no=$_POST["bpartner_no"];
    $o->bpartner_name=$_POST["bpartner_name"];
    $o->bpartnergroup_id=$_POST["bpartnergroup_id"];
    $o->companyno=$_POST["companyno"];
    $o->alternatename=$_POST["alternatename"];
    $o->employeecount=$_POST["employeecount"];
    $o->employee_id=$_POST["employee_id"];
    $o->industry_id=$_POST["industry_id"];
    $o->terms_id=$_POST["terms_id"];
    $o->purchasepricelist_id=$_POST["purchasepricelist_id"];
    $o->salespricelist_id=$_POST["salespricelist_id"];
    $o->isactive=$_POST["isactive"];if($o->isactive=="true")$o->isactive=1;else $o->isactive=0;
    $o->isdebtor=$_POST["isdebtor"];if($o->isdebtor=="true")$o->isdebtor=1;else $o->isdebtor=0;
    $o->iscreditor=$_POST["iscreditor"];if($o->iscreditor=="true")$o->iscreditor=1;else $o->iscreditor=0;
    $o->isdealer=$_POST["isdealer"];if($o->isdealer=="true")$o->isdealer=1;else $o->isdealer=0;
    $o->isprospect=$_POST["isprospect"];if($o->isprospect=="true")$o->isprospect=1;else $o->isprospect=0;
    $o->istransporter=$_POST["istransporter"];if($o->istransporter=="true")$o->istransporter=1;else $o->istransporter=0;
    $o->currency_id=$_POST["currency_id"];
    $o->defaultlevel=$_POST["defaultlevel"];
    $o->tooltips=$_POST["tooltips"];
    $o->bpartner_url=$_POST["bpartner_url"];
    $o->description=$_POST["description"];

    if($o->updateBPartnerBasicInfo())
        echo "OK<br/>$o->errormessage";
    else
        echo "Error:<br/>$o->errormessage";
    break;
case "showForm":
        include_once "class/SelectCtrl.inc.php";
        $ctrl= new SelectCtrl();
        $bpartner_id=$_GET['bpartner_id'];
   // echo print_r($_GET);
        if($bpartner_id>0){
           $o->fetchBPartner($bpartner_id);
            $o->getBasicInputForm("edit");
           // $o->getAccountingInputForm("edit");
    }
    else
        echo "<b class=\"highlight\">Error! Retrieved invalid business partner id, please choose appropriate business partner.</b>";

    break;

default:
include "menu.php";


$o->searchbpartnergroupctrl= $ctrl->getSelectBPartnerGroup(2,"searchbpartnergroup_id","","","classic");

$xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
$arrayresult=$o->searchAToZ();
$quicknamelist=$arrayresult[0];
$filterstring=$arrayresult[1];
$tabcount=6;
if($havewriteperm==1)
   $permctrl=" rowinsertenabled=\"true\"      rowdeleteenabled=\"true\"     toolbarenabled=\"true\"      ";
else
   $permctrl=" rowinsertenabled=\"false\"   autosaveenabled=\"false\"   rowdeleteenabled=\"false\"      toolbarenabled=\"false\"      ";

if(isset($_GET['filterstring'])){
$filterstring=$_GET['filterstring'];
$isactive="1";
}else{
$filterstring="";
$isactive="";
}

echo <<< EOF
<script type="text/javascript" src="include/jquery.tabSwitch.yui.js"></script>
<link rel="stylesheet" href="include/nitobi/nitobi.grid/nitobi.grid.css" type="text/css" />
<link rel="stylesheet" href="include/nitobi/nitobi.combo/nitobi.combo.css" type="text/css" />
<script type="text/javascript" src="include/nitobi/nitobi.toolkit.js"></script>
<script type="text/javascript" src="include/nitobi/nitobi.grid/nitobi.grid.js"></script>
<script type="text/javascript" src="include/nitobi/nitobi.combo/nitobi.combo.js"></script>

<script type="text/javascript" src="include/showhidesearchform.js"></script>
<script type="text/javascript" src="include/tabswitchfunction.js"></script>
<script type="text/javascript" src="include/firefox3_6fix.js"></script>
<script type="text/javascript" src="include/specialbutton.js"></script>
<script type="text/javascript" src="include/stringprocess.js"></script>


<script>

$(document).ready((function (){
    nitobi.loadComponent('DataboundGrid');

    nitobi.loadComponent('searchbpartnergroup_id');
    changetabstyle(1,$tabcount);
    document.getElementById('currentbpartner_id').value=0;

   

})); 


 function init(){}

     function search(){

        var grid = nitobi.getGrid("DataboundGrid");
        var searchbpartner_name=document.getElementById("searchbpartner_name").value;
        var searchisactive=document.getElementById("searchisactive").value;

        /*
         *only user isadmin will have element searchisdeleted (apply in every windows and records)
         *check element is exist before submit variable to avoid javascript failure
         */
        if(document.getElementById("searchisdeleted"))
        var searchisdeleted=document.getElementById("searchisdeleted").checked;

        //Submit javascript to grid with _GET method
	grid.getDataSource().setGetHandlerParameter('searchbpartner_name',searchbpartner_name);
	grid.getDataSource().setGetHandlerParameter('searchisactive',searchisactive);
	grid.getDataSource().setGetHandlerParameter('searchisdeleted',searchisdeleted);

        //reload grid data
	grid.dataBind();
    }

    //optional function to generate primary key value, ignore this function because we use autogen method
    function GetNewRecordID()
    {
        //      var myAjaxRequest = new nitobi.ajax.HttpRequest();
        //      myAjaxRequest.handler = 'getMaxID.php?idname=country_id&tablename=sim_bpartner';
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
        $('#msgbox').fadeTo('veryfast', 0, function() {});
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
           $('#msgbox').fadeTo('slow', 1, function() {});
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
             document.getElementById('msgbox').innerHTML;
             grid.dataBind();
         }
         else
           document.getElementById('msgbox').innerHTML="";
       $('#msgbox').fadeTo('slow', 1, function() {});
    }

    //if table load completely trigger this function
    function dataready(){
    }

    //if user click particular column trigger this function
    function clickrecord(eventArgs){
               
                    var grid = eventArgs.getSource();
                    row=eventArgs.getCell().getRow();
                    col=eventArgs.getCell().getColumn();
                    var value1 = grid.getCellObject(row,0).getValue();
                    var value2 = grid.getCellObject(row,1).getValue();
                    var id = grid.getCellObject(row,10).getValue();

                    document.getElementById('cellvalue').innerHTML="Business Partner : "+value1 + " - " + value2;
                    document.getElementById('currentbpartner_id').value=id;

          
    }

    function loadbasicinfo(){
     var currentbpartner_id= document.getElementById('currentbpartner_id').value;
  
     var data="action=showForm&bpartner_id="+currentbpartner_id;
         document.getElementById('Tab1').innerHTML="";
         $.ajax({
             url: "bpartner.php",type: "GET",data: data,cache: false,
                 success: function (html) {
                            document.getElementById('Tab1').innerHTML=html;
                            nitobi.loadComponent("bpartnergroup_id");
                            nitobi.loadComponent("terms_id");
                            nitobi.loadComponent("industry_id");
                            nitobi.loadComponent("employee_id");
                            nitobi.loadComponent("currency_id");
                            nitobi.loadComponent("salespricelist_id");
                            nitobi.loadComponent("purchasepricelist_id");
                          }
            }); //close $.ajax

     }

function validation() {
         var bpartner_id=$('input[name=currentbpartner_id]').val();
         var bpartner_no = $('input[name=bpartner_no]').val();
         var bpartner_name = $('input[name=bpartner_name]').val();
         var bpartnergroup_id=document.getElementById("bpartnergroup_id").jsObject.GetSelectedRowValues()[0];
         var industry_id=document.getElementById("industry_id").jsObject.GetSelectedRowValues()[0];
         var companyno=$('input[name=companyno]').val();
         var alternatename=$('input[name=alternatename]').val();
         var employeecount = $('input[name=employeecount]').val();
         var employee_id=document.getElementById("employee_id").jsObject.GetSelectedRowValues()[0];
         var salespricelist_id=document.getElementById("salespricelist_id").jsObject.GetSelectedRowValues()[0];
         var purchasepricelist_id=document.getElementById("purchasepricelist_id").jsObject.GetSelectedRowValues()[0];

         var isactive=document.getElementById("isactive").checked;
         var isdebtor=document.getElementById("isdebtor").checked;
         var iscreditor=document.getElementById("iscreditor").checked;
         var istransporter=document.getElementById("istransporter").checked;
         var isdealer=document.getElementById("isdealer").checked;
         var isprospect=document.getElementById("isprospect").checked;
         var terms_id=document.getElementById("terms_id").jsObject.GetSelectedRowValues()[0];
         var currency_id=document.getElementById("currency_id").jsObject.GetSelectedRowValues()[0];
         var defaultlevel=$('input[name=defaultlevel]').val();
         var tooltips=$('input[name=tooltips]').val();
         var bpartner_url=$('input[name=bpartner_url]').val();
         var description=$('textarea[name=description]').val();
         
         if (bpartner_no=='') {
             $('input[name=bpartner_no]').addClass('hightlight');
             return false;
         } else $('input[name=bpartner_no]').removeClass('hightlight');
         if (bpartner_name=='') {
             $('input[name=bpartner_name]').addClass('hightlight');
             return false;
         } else $('input[name=bpartner_name]').removeClass('hightlight');
         if (employeecount=='') {
             $('input[name=employeecount]').addClass('hightlight');
             return false;
         } else $('input[name=employeecount]').removeClass('hightlight');
         var data = 'action=save'+
                    '&bpartner_id='+bpartner_id+
                    '&bpartner_no=' + bpartner_no +
                    '&bpartner_name=' + bpartner_name+
                    '&bpartnergroup_id='+ bpartnergroup_id +
                    '&industry_id='+ industry_id +
                    '&companyno='+ companyno +
                    '&alternatename='+ alternatename +
                    '&employeecount='+ employeecount +
                    '&employee_id='+ employee_id +
                    '&isactive='+ isactive +
                    '&isdebtor='+ isdebtor +
                    '&iscreditor='+ iscreditor +
                    '&salespricelist_id='+ salespricelist_id +
                    '&purchasepricelist_id='+ purchasepricelist_id +
                    '&istransporter='+ istransporter +
                    '&isdealer='+ isdealer +
                    '&isprospect='+ isprospect +
                    '&terms_id='+ terms_id +
                    '&currency_id='+ currency_id +
                    '&defaultlevel='+ defaultlevel +
                    '&tooltips='+ tooltips +
                    '&bpartner_url='+ bpartner_url +
                    '&description='+ description;

        $('#basicsavediv').fadeTo('veryfast', 0, function() {
          $.ajax({
             url: "bpartner.php",type: "POST",data: data,cache: false,
                 success: function (html) {
                            if (Left(html,2)=="OK") {
                                    document.getElementById('basicsavediv').innerHTML="Record saved successfully.<br/>"+
                                                 document.getElementById('basicsavediv').innerHTML;
                            }
                            else{ 
                                    document.getElementById('basicsavediv').innerHTML="<b style='color:red'><br/>"+html+".</b><br/>"+
                                                 document.getElementById('basicsavediv').innerHTML;
                            }
                          }
            }); //close $.ajax
        });

       
        $('#basicsavediv').fadeTo('veryfast', 1, function() {});

         return false;
    }//exit validation


</script>

$quicknamelist
<input type="button" id="showHideSearchButton" onclick="showSearchForm()" value="Show Search Form">
<input type="hidden" id="currentbpartner_id" value="0"  name="currentbpartner_id">
<div id="divSearch" style="display:none">

EOF;



$o->showSearchForm();
echo <<< EOF
<input type="button" id="hideSearchButton" onclick="showSearchForm()" value="Hide Search Form">
</div>
<br/><br/>
<div id="cellvalue">Business Partner: </div>
<table cellpadding="0" cellspacing="0">
<tr>
<td id="tab1" class="switchtab"><a class="tabSelect" href="#Tab0" rel="0" onclick=changetabstyle(1,$tabcount) >Business Partner List</a></td>
<td id="tab2" class="switchtab"><a class="tabSelect" href="#Tab1" rel="1" onclick="changetabstyle(2,$tabcount);loadbasicinfo()">Edit Company Info</a></td>
<td id="tab4" class="switchtab"><a class="tabSelect" href="#Tab3" rel="2" onclick=changetabstyle(3,$tabcount)>Follow Up</a></td>
<td id="tab7"></td>

</tr>
<tr><td colspan="6" class="tabregion" height="3px"></td></tr>
</table>

	<div class="SlideTab" id="Tab0" width="100%">
		<h3>Business Partner List</h3>
EOF;
$o->showBPartnerTable();

echo <<< EOF
	</div>
	<div class="SlideTab" id="Tab1">Edit Basic Info</div>
	<div class="SlideTab" id="Tab2">
		<h3>View Info</h3>

	</div>



EOF;


require(XOOPS_ROOT_PATH.'/footer.php');
break;

}


?>

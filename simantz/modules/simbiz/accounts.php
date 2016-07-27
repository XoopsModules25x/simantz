<?php

include "system.php";
include 'class/Accounts.php';

$o = new Accounts();

$action=$_REQUEST['action'];
$o->updated=date("Y-m-d H:i:s",time());
$o->updatedby=$xoopsUser->getVar("uid");

switch($action){
case "ajaxfetch":
    if($o->fetchAccounts($_REQUEST['accounts_id'] ) ){
        $o->returnAccountsXML();
    }
    else
        echo "<xml><errortext>Cannot retrieve accounts_id:".$_REQUEST['accounts_id']."</errortext></xml>";

break;

case "ajaxgetaccounttree":
    echo $o->showChildAccountTree(0,0);
    break;
case "ajaxdelete":
    $o->accounts_id=$_POST['accounts_id'];

    if(!$o->deleteAccounts($o->accounts_id))
            echo "Warning! Cannot delete this account due to unknown reason.";
    else
            echo "Delete record successfully.";
    break;
case "ajaxsave":
                    
                    $o->accounts_id=$_POST['accounts_id'];
                    $o->accounts_name=$_POST['accounts_name'];
                    $o->defaultlevel=$_POST['defaultlevel'];
                    $o->parentaccounts_id=$_POST['parentaccounts_id'];
                    $o->parentaccounts_idname=$_POST['parentaccounts_idname'];
                    $o->description=$_POST['description'];
                    $o->accountcode_full=$_POST['accountcode_full'];
                    $o->ishide=$_POST['ishide'];
                    $o->tax_id=$_POST['tax_id'];
                    $o->placeholder=$_POST['placeholder'];
                    $o->organization_id=$_POST['organization_id'];
                    $o->accountgroup_id=$_POST['accountgroup_id'];
                    $o->accountgroup_idname=$_POST['accountgroup_idname'];
                    $o->account_type=$_POST['account_type'];
                    $o->account_typename=$_POST['account_typename'];
                    
                   
                   echo "<?xml version='1.0' encoding='utf-8' ?><Result>";
if($o->validateForm()){
    if( $o->accounts_id>0)
            if($o->updateAccounts())
                      echo "<status>1</status><detail><msg>Record save successfully</msg></detail>";
            else
                      echo "<status>0</status><detail><msg>Cannot save record due to internal error</msg></detail>";

    else
            if($o->insertAccounts())
                      echo "<status>1</status><accounts_id id='$o->accounts_id'>$o->accounts_id</accounts_id><detail><msg>Record save successfully</msg></detail>";
            else
                      echo "<status>0</status><detail><msg>Cannot save record due to internal error</msg></detail>";

}
else{
   $o->generateValidationError();
}
 echo "</Result>";
break;

case "ajaxselectaccounts":
        $o->accounts_id=$_GET['accounts_id'];
        if($o->accounts_id=="")
                $o->accounts_id=0;
        echo $o->getSelectPlaceHolderAccounts($o->accounts_id);
    break;
case "ajaxselectaccounttype":
     $accounttype=$_GET['account_type'];
        if($accounttype=="")$accounttype=1;

    echo $o->returnAccountsTypeXML($accounttype);
    break;
case "ajaxselectaccountgroup":
    $accountgroup_id=$_GET['accountgroup_id'];
    if($accountgroup_id=="")$accountgroup_id=0;
     include "class/AccountGroup.php";
    $ag = new AccountGroup();
    $accgroupoptionlist=$ag->getSelectAccountGroup($accountgroup_id);
     
        

    echo $accgroupoptionlist;
    break;
default:

        $xoTheme->addStylesheet("$url/modules/simantz/include/window.css");
        $xoTheme->addStylesheet("$url/modules/simantz/include/popup.css");
        $xoTheme->addScript("$url/modules/simantz/include/popup.js");
        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
        include "menu.php";

    $accountslist=$o->showChildAccountTree(0,0);
   
    $formname=$o->getInputForm(0);

    echo <<< EOF
    <script>

    function reloadAccounts(){
            var data="action=ajaxgetaccounttree";
            $.ajax({
                 url: "accounts.php",type: "GET",data: data,cache: false,
                     success: function (xml) {
                         document.getElementById("treeAccount").innerHTML=xml;
                         }
                    });

        }

        function ajaxLoadAccountTypeList(acc_type){
         var data="action=ajaxselectaccounttype&account_type="+acc_type;
            $.ajax({
                 url: "accounts.php",type: "GET",data: data,cache: false,
                     success: function (xml) {
                        $("#account_type").html(xml);
                             document.getElementById("account_type").value=acc_type;

                         }
                    });

        }

        function allowSave(result){
            if(result==true){
            document.getElementById("submit").style.display="";
            document.getElementById("submit").type="submit";
            }
            else{
            document.getElementById("submit").style.display="none";
            document.getElementById("submit").type="button";
            }
        }

        function validate(value,validationtype,pattern,controlobject){
    
              var data="action="+"validation"+
                        "&value="+value+
                        "&validationtype="+validationtype+
                        "&pattern="+pattern;
              $.ajax({
                     url: "../simantz/validation.php",type: "GET",data: data,cache: false,
                         success: function (xml) {

                        $(xml).find("validation").each(function()
                                {  
                                var currentaid = $(this).attr("id");
                                    var status = $(this).find("status").text();
                                    var msg1=$(this).find("msg").text();
                                    
                                    if(status=="1"){
                                    $("#"+controlobject.id).removeClass('validatefail');
                                    allowSave(true);
                                    }
                                    else{
                                    $("#"+controlobject.id).addClass('validatefail');
                                    allowSave(false);
                                 //   controlobject.focus();
                                    }

                                });
                    }});
       }

    
        function saverecord(){
                document.getElementById("popupmessage").innerHTML="Saving data...";
                popup('popUpDiv');
                var errordiv=document.getElementById("errormsg");
                errordiv.style.display="none";
                var aid=document.getElementById("accounts_id").value;
                var aname=document.getElementById("accounts_name").value;
                var defaultlevel=document.getElementById("defaultlevel").value;

                var paid=document.getElementById("parentaccounts_id").value;
                var paidindex = document.getElementById("parentaccounts_id").selectedIndex;
                var paidname = document.getElementById("parentaccounts_id").options[paidindex].text;
    
                var desc=document.getElementById("description").value;
                var accountcode_full=document.getElementById("accountcode_full").value;

                var accountgroup_id=document.getElementById("accountgroup_id").value;
                var accountgroup_idindex = document.getElementById("accountgroup_id").selectedIndex;
                var accountgroup_idname = document.getElementById("accountgroup_id").options[accountgroup_idindex].text;

                var tax_id=document.getElementById("tax_id").value;
                var placeholder=0;
                if(document.getElementById("placeholder").checked==true)
                    placeholder=1;
                var ishide=0;
                if(document.getElementById("ishide").checked==true)
                    ishide=1;
                var accountcode_full=document.getElementById("accountcode_full").value;
                var organization_id=document.getElementById("organization_id").value;

                var account_type=document.getElementById("account_type").value;
                var account_typeindex = document.getElementById("account_type").selectedIndex;
                var account_typename = document.getElementById("account_type").options[account_typeindex].text;

            var data="action="+"ajaxsave"+
                    "&accounts_id="+aid+
                    "&accounts_name="+aname+
                    "&defaultlevel="+defaultlevel+
                    "&parentaccounts_id="+paid+
                    "&parentaccounts_idname="+paidname+
                    "&description="+desc+
                    "&accountcode_full="+accountcode_full+
                    "&ishide="+ishide+
                    "&tax_id="+tax_id+
                    "&placeholder="+placeholder+
                    "&organization_id="+organization_id +
                    "&accountgroup_id="+accountgroup_id+
                    "&accountgroup_idname="+accountgroup_idname+
                    "&account_type="+account_type+
                    "&account_typename="+account_typename;
                   
            $.ajax({
                 url: "accounts.php",type: "POST",data: data,cache: false,
                     success: function (xml) {
                     
                     var status=$(xml).find("status").text();
                     
                     if(status==1){
                       errordiv.style.display="none";
                       
                              if(aid==0){
                                    document.getElementById("accounts_id").value=$(xml).find("accounts_id").text();
                                 
                                }
                        }
                    else if(status==0){
                                errordiv.style.display="";
                            errordiv.innerHTML="Cannot save record due to internal error"+xml;
                     }
                     else if(status=-1){
                            errordiv.style.display="";
                            var fieldname="";
                            var msg="";
                             $(xml).find("field").each(function()
                                {
                                var id=$(this).attr("id");
                                 fieldname=$(this).find("fieldname").text();
                                  $("#"+fieldname).addClass('validatefail');
                                   msg=msg+$(this).find("msg").text()+"<br/>";
                                
                                 });
                                 document.getElementById("errormsg").innerHTML=msg;
                    }
                     else
                     alert("unknown status");
                     document.getElementById("popupmessage").innerHTML=xml;
               
                    reloadAccounts();
                    document.getElementById("popupmessage").innerHTML="Completed!";
                    popup('popUpDiv');
                }});




        }

        function refreshparentaccountlist(accounts_id){

          //  $("#parentaccounts_id").html("");
            var data="action=ajaxselectaccounts&accounts_id="+accounts_id;
            $.ajax({
                 url: "accounts.php",type: "GET",data: data,cache: false,
                     success: function (xml) {
                      $("#parentaccounts_id").html(xml);
                    document.getElementById("parentaccounts_id").value=accounts_id;
                    }
            });

    }

    function refreshaccountgrouplist(accountgroup_id){

         
            var data="action=ajaxselectaccountgroup&accountgroup_id="+accountgroup_id;
            $.ajax({
                 url: "accounts.php",type: "GET",data: data,cache: false,
                     success: function (xml) {

                      $("#accountgroup_id").html(xml);
                    document.getElementById("accountgroup_id").value=accountgroup_id;
                    }
            });

    }

//

        function showAccountsForm(aid){
           var errordiv=document.getElementById("errormsg");
            errordiv.innerHTML="";
            errordiv.style.display="none";
            var data="action=ajaxfetch&accounts_id="+aid;
            var paid=0;
            $.ajax({
                 url: "accounts.php",type: "GET",data: data,cache: false,
                     success: function (xml) {
                            
                             $(xml).find("Account").each(function()
                                {

                                    var currentaid = $(this).attr("id");
                                 
                                    var aname=$(this).find("accounts_name").text();
                                    var defaultlevel=$(this).find("defaultlevel").text();
                                    paid=$(this).find("parentaccounts_id").text();
                                    var accountcode_full=$(this).find("accountcode_full").text();
                                    var accountype=$(this).find("account_type").text();
                                    var accountgroup_id=$(this).find("accountgroup_id").text();
                                    var desc=$(this).find("description").text();
                                    
                                    var pholder=$(this).find("placeholder").text();
                                    var ishide=$(this).find("ishide").text();
                                    document.getElementById("accounts_id").value=aid;
                                    document.getElementById("accounts_name").value=aname;
                                    document.getElementById("defaultlevel").value=defaultlevel;
                                    document.getElementById("description").value=desc;
                                    document.getElementById("accountcode_full").value=accountcode_full;
                                    
                                    if(ishide==1)
                                        document.getElementById("ishide").checked=true;
                                    else
                                        document.getElementById("ishide").checked=false;
                                    if(pholder==1)
                                        document.getElementById("placeholder").checked=true;
                                    else
                                        document.getElementById("placeholder").checked=false;

                                    //start load selection content
                                    
                                    ajaxLoadAccountTypeList(accountype);
                                     refreshparentaccountlist(paid);
                                     
                                     refreshaccountgrouplist(accountgroup_id);
                                    ////load selection content
                                });//close each
          
                              }//close success
                        
                }); //close $.ajax
                       
  
        }
    
        function deleterecord(){

          if(confirm('Delete this account?')){
           var aid=document.getElementById("accounts_id").value;
            var data="action=ajaxdelete&accounts_id="+aid;
            $.ajax({
                 url: "accounts.php",type: "POST",data: data,cache: false,
                     success: function (xml) {
                        reloadAccounts();
                        addChildAccounts(0);
                    }});
          }
        }

        function addChildAccounts(accounts_id){
                    if(accounts_id==0){
                                    document.getElementById("accounts_id").value=0;
                                    document.getElementById("accounts_name").value="";
                                    document.getElementById("defaultlevel").value=10;
                                    document.getElementById("description").value="";
                                    document.getElementById("parentaccounts_id").value=0;
                                    document.getElementById("account_type").value=1;
                                    document.getElementById("accountcode_full").value="";
                                    document.getElementById("ishide").checked=false;
                                    document.getElementById("placeholder").checked=false;
                    }
                    else{
       document.getElementById("accounts_id").value=0;
                                    document.getElementById("accounts_name").value="";
                                    document.getElementById("defaultlevel").value=10;
                                    document.getElementById("description").value="";
                                    document.getElementById("parentaccounts_id").value=accounts_id;
                                    document.getElementById("account_type").value=1;
                                    document.getElementById("accountcode_full").value="";
                                    document.getElementById("ishide").checked=false;
                                    document.getElementById("placeholder").checked=false;
                    }
    }
     </script>
    <br/>
    <small style='color:black'>*Click [+] to add new sub-account</small>
    <table border=1px>
    <tr>
    <td width="50%" style='vertical-align:top'><div id="treeAccount" class="searchformblock">$accountslist</div></td>
    <td width="50%" style='vertical-align:top'><div id="formAccounts" class="searchformblock">$formname</div></td>
    </tr></table>




EOF;

require(XOOPS_ROOT_PATH.'/footer.php');
break;
}

?>
